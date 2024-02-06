# Ugyfel

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]


## Installation

Via Composer

```bash
composer require alexgithub987/ugyfel
```

## Usage

```bash
 $data_array = [
   "nev" => "Dezső Miskolc", 
   "email" => "mjeszt@dezsomiskolc.hu", 
   "telefon" => "06301234567", 
   "adoszam" => "asdasfaf", 
   "ceg" => "", 
   "cim_type" => "SZEKHELY", 
   "orszag" => "HU", 
   "irsz" => "6800", 
   "varos" => "Hódmezővásárhely", 
   "kozterulet" => "", 
   "kozterulet_jelleg" => "", 
   "hsz" => "", 
   "egyszeru_cim" => "6800 Hódmezővásárhely Makói ország út 77178 hrsz." 
]; 

$ugyfel = new Ugyfel;
$ugyfel->index($data_array);
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.


## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author@email.com instead of using the issue tracker.

## Credits

- [Author Name][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/alexgithub987/ugyfel.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/alexgithub987/ugyfel.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/alexgithub987/ugyfel/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/alexgithub987/ugyfel
[link-downloads]: https://packagist.org/packages/alexgithub987/ugyfel
[link-travis]: https://travis-ci.org/alexgithub987/ugyfel
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/alexgithub987
[link-contributors]: ../../contributors
