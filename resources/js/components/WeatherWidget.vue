<template>
     <div class="w-128 px-2 items-center">
            <input type="search" id="address" class="py-2 px-2 form-control" list="pref" placeholder="where are we going?" />
            <datalist id="pref"> 
            <option v-for="n in ['Tokyo','Yokohama', 'Kyoto','Osaka','Sapporo', 'Nagoya']" :key="n">{{n}}</option>
            </datalist>
            <button v-on:click="greet" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-2 rounded">
            Go</button>
            <p>Selecteed: <strong id="address-value">none</strong></p>
            
        </div>
    <div class="columns-2xs px-2 py-2">
        <div class="w-128 w-full bg-gray-900 text-white text-sm rounded-lg overflow-hidden">
                <div class="current-weather relative">
                    
                    <div class="flex items-center justify-between px-4 py-1">
                        <div class="flex items-center">
                            <div>
                                <div class="text-5xl font-semiboll">{{ currentWeather.actual }}&#176;C</div>
                                <div class="text-gray-400">{{ currentWeather.feels }} &#176;C </div>
                            </div>
                            <div class="ml-5">
                                <div class="font-semibold">{{ currentWeather.description }}</div>
                                <div class="text-gra-400">{{ location }}</div>
                            </div>
                            
                        </div>
                        <div>
                            <img :src="currentWeather.icon" alt="">
                        </div>
                    </div>
                    <button @click="isFutureWeatherVisible = !isFutureWeatherVisible" class="absolute right-0 bottom-0 mb-2 mr-2 text-xs">Toggle</button>
                </div>
                <ul v-show="isFutureWeatherVisible" class="future-weather bg-gray-800 px-4 py-6 space-y-8">
                    <li v-for="weather in futureWeather" :key="weather.dt" class="grid grid-cols-weather items-center">
                        <div class="text-gray-400">
                            {{ convertToDay(weather.dt) }}
                        </div>
                        <div class="flex items-center">
                            <div>
                                <img :src="convertToImage(weather.weather[0].icon)" />
                            </div>
                            <div>
                                {{ ucfirst(weather.weather[0].description) }}
                            </div>
                        </div>
                        <div class="text-right text-xs">
                            <div>{{ Math.round(weather.main.temp_max) }}&#176;C</div>
                            <div>{{ Math.round(weather.main.temp_min) }}&#176;C</div>

                        </div>
                    </li>
                </ul>
            </div>
            <div class="w-128 w-full overflow-hidden">
                <div class="font-bold">Venues around {{ location }}</div>
                <ul class="future-weather bg-gray-400 rounded-lg px-4 py-6 space-y-8">
                    <li v-for="place in places" :key="place.fsd_id" class="grid grid-cols-3 items-center">
                        <div class="">
                            <a class="no-underline hover:underline font-bold" 
                            target="_blank"
                            :href="getMapLink(place.name+place.location.address)">
                            {{ place.name }}
                            </a>
                        </div>
                        <div class="flex items-center">
                            <div v-for="category in place.categories" :key="category.id">
                                <img :src="category.icon.prefix+'44'+category.icon.suffix" />
                            </div>
                        </div>
                        <div class="text-right text-xs">
                            <div>{{ place.location.address }}</div>
                        </div>
                    </li>
                </ul>
            </div>
    </div>
</template>

<script>
import axios from 'axios';

    export default {
        mounted() {
            this.fetchCurrentWeather()
            this.fetchFutureWeather()
            this.fetchPlaces()
        },
        watch: {
            location() {
                this.fetchCurrentWeather()
                this.fetchFutureWeather()
                this.fetchPlaces()
            }
        },
        data() {
            return {
                location: 'Tokyo',
                currentWeather: {
                    actual: '',
                    feels: '',
                    description: 'Loading..'
                },
                futureWeather: [],
                isFutureWeatherVisible: false,
                places: [],
            }
        },
        methods: {
            greet: function (event) {
                var address = document.querySelector('#address');
                // メソッド内の `this` は、 Vue インスタンスを参照します
                this.location = address.value;
                // `event` は、ネイティブ DOM イベントです
            },
            convertToDay(timestamp) {
                const newData = new Date(timestamp*1000)
                const days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']

                return days[newData.getDay()]+','+newData.getMonth()+'/'+newData.getDate()
                +' '+newData.getHours()+':'+newData.getMinutes().toString().padStart(2, '0')
            },
            convertToImage(icon) {
                return `http://openweathermap.org/img/wn/${icon}.png`
            },
            getMapLink(place) {
                return `https://www.google.com/maps/search/?api=1&query=${place}`
            },
            fetchCurrentWeather() {
                axios.get(`/weather?location=${this.location}`)
                .then(response => {
                    this.currentWeather.actual = Math.round(response.data.main.temp)
                    this.currentWeather.feels = Math.round(response.data.main.feels_like)
                    this.currentWeather.description = this.ucfirst(response.data.weather[0].description)
                    this.currentWeather.icon = `https://openweathermap.org/img/wn/${response.data.weather[0].icon}@4x.png`

                    console.log(response);
                }
                )
            },
            fetchFutureWeather() {
                axios.get(`/future-weather?location=${this.location}`)
                .then(response => {
                    this.futureWeather = response.data.list
                }
                )
            },
            fetchPlaces() {
                axios.get(`/places?location=${this.location}`)
                .then(response => {
                    this.places = response.data.results
                    console.log(response);
                }
                )
            },
            ucfirst(stringToConvert) {
                return stringToConvert.charAt(0).toUpperCase() + stringToConvert.slice(1)
            },
        }
    }
    
    
</script>