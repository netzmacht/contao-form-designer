Contao Form Designer
====================

[![Build Status](http://img.shields.io/travis/netzmacht/contao-form-designer/master.svg?style=flat-square)](https://travis-ci.org/netzmacht/contao-form-designer)
[![Version](http://img.shields.io/packagist/v/netzmacht/contao-form-designer.svg?style=flat-square)](http://packagist.org/packages/netzmacht/contao-form-designer)
[![License](http://img.shields.io/packagist/l/netzmacht/contao-form-designer.svg?style=flat-square)](http://packagist.org/packages/netzmacht/contao-form-designer)
[![Downloads](http://img.shields.io/packagist/dt/netzmacht/contao-form-designer.svg?style=flat-square)](http://packagist.org/packages/netzmacht/contao-form-designer)
[![Contao Community Alliance coding standard](http://img.shields.io/badge/cca-coding_standard-red.svg?style=flat-square)](https://github.com/contao-community-alliance/coding-standard)

The Contao Form Designer provides more flexibility to customize form rendering

 - Splitting form templates into separate template for the layout, label, control, help and error messages
 - Defining customized form layouts in the theme
 - Choose a custom form layout in the form, module or content element 
 - Additional help message feature.
 - Custom css class for form control element.


Changelog
---------

See the [CHANGELOG.md](CHANGELOG.md)

Requirements
------------

 - min. Contao 4.13 oder Contao 5
 - min. PHP 8.1 
 
 
Install
-------

### Managed edition

When using the managed edition it's pretty simple to install the contao form designer. Just search for the package in the
Contao Manager and install it. Alternatively you can use the CLI.  

```bash
# Using the contao manager
$ php contao-manager.phar.php composer require netzmacht/contao-form-designer

# Using composer directly
$ php composer.phar require netzmacht/contao-form-designer
```
