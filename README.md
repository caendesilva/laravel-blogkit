<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Laravel Blog Starter Kit

## Kickstart the development of your Laravel Blog with this Starter Kit built Laravel 9, TailwindCSS, AlpineJS, and Livewire!

## Get Started
Once you have installed the Laravel app you can use the helper command to create an admin account using `php artisan admin:create` in your terminal.

### How to set up the blog using the demo settings
**Important! This guide is just to demo the site. For production use you must follow the production guide as this guide allows anyone to log in as admin! **

1. Clone the git repo
2. In the config file `config\blog.php` change `demoMode` to `true`
3. In your terminal, run `php artisan migrate --seed`

### How to set up the blog for production
1. Clone the git repo
2. In your terminal, run `php artisan migrate`
3. In your terminal, run `php artisan admin:create` and follow the on-screen instructions to create an admin account. Make sure to set a strong password or passphrase!
4. Next, follow the instructions in the [Official Deployment Documentation](https://laravel.com/docs/9.x/deployment) to ensure you are following the best practices.

#### How to add authors
It may be useful to add more authors to your blog. First, instruct the author to create a standard account. Then, you as admin go to the dashboard and press the "manage" button and check the "Is User Author?" tick and press save.

## Contribute!
PRs are very much welcome!

Current todo list:
- [ ] Add Sweet Alerts, or similar, to handle session flashes
- [ ] Add "load more" style pagination to comments
- [x] Add this readme as a page on the demo site

## Open Source Attributions
The Starter Kit is a modern [TALL stack](https://tallstack.dev/) application based on [Laravel Breeze](https://github.com/laravel/breeze) (MIT) using:
- [TailwindCSS 3](https://tailwindcss.com/) (MIT)
- [AlpineJS 3](https://alpinejs.dev/) (MIT)
- [Laravel 9](https://laravel.com/) (MIT)
- [Livewire 2](https://laravel-livewire.com/) (MIT)

Featured images on blog posts used by the seeder come from [Unsplash](https://unsplash.com/) via [picsum.photos](https://picsum.photos/) (Image License)[https://unsplash.com/license]
Some of the frontend components are from [Flowbite](https://github.com/themesberg/flowbite) (MIT)


## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com).

If you discover a security vulnerability within this package, please send an e-mail to the creator, Caen De Silva, via [caen@desilva.se](mailto:caen@desilva.se).

All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

This starter kit is also open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Credit is not required, but it is highly appreciated. If this project helped you, please leave a star and let me know! I'd LOVE to see what you build using this. I'm happy to add a link to your site in this readme if you are using it.