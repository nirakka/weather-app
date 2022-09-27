<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# 気象情報アプリ
## 機能

- 各都市の天気予報を表示
- 各都市のfoursquareで登録されている場所を表示
- レスポンシブデザインで作成

## 使用技術
- Laravel
- Vue.js
- Tailwindcss
- Openweathermap api
- Foursquare api

## デプロイ方法
### git clone
```
$ git clone https://github.com/nirakka/weather-app.git
$ npm install  
$ php artisan serve
$ npm run dev
```

## 工夫した点

### コンテンツの配置
天気予報の情報をトグルで展開できるようにしました。基本は2列表示にし、横幅の大きさによって1列に表示するようにしました。アイコンの表示なども見やすいように配置を工夫しました。

### オートコンプリート
入力が容易となるようにオートコンプリートで補完が行えます。

### APIへのアクセス方法
クライアントから直接APIにアクセスするのではなく、
サーバーサイドを経由してAPIにアクセスするようにしています。

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
