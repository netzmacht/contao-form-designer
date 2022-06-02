Changelog
=========

1.3.1 (2022-06-02)
------------------

 - Fix form password in Contao 4.13
 - Improve PHP 8 compatibility

1.3.0 (2022-06-02)
------------------

 - Contao 4.13 compatibility

1.2.0 (2021-10-07)
------------------
 
 - Add the option to override the form layout for a form field
 - Add the option to override the form control and form layout template  for a form field
 - Allow customizing supported elements, modules and widgets by the bundle configuration

1.1.8 (2021-03-30)
------------------

 - Always detect widget type from the registry insteadof using the `type attribute` (Fixes https://github.com/contao-bootstrap/form/issues/47) 

1.1.7 (2021-03-09)
------------------

 - Fix widget type detection for widgets not defining `type` attribute

1.1.6 (2019-03-19)
------------------

 - Catch Contao\CoreBundle\DataContainer\PaletteNotFoundException for forward compatibility (#42). Resolves also 
  contao/contao#378
 
1.1.5 (2019-03-14)
------------------

 - Fix incompatibility with PHP 7.3 in `ThemeImportListener`.

1.1.4 (2018-11-26)
------------------

 - Fix referenced module in content element not handled in contextual form layout listener.
 
1.1.3 (2018-11-26)
------------------

 - Fix referenced module in content element not handled in contextual form layout listener.

1.1.2 (2018-09-27)
------------------

 - Fix broken captcha in Contao 4.6
 
1.1.0 (2018-08-24)
------------------

 - Fix compatibility with Contao 4.6 / Symfony 4
 
1.1.0 (2018-07-02)
------------------

 - Provide method to get the default layout without having a widget.

1.0.8 (2018-04-23)
------------------

 - Fix naming issue of default control template (See #1).
 
1.0.7 (2018-03-01)
------------------

 - Loosen type restrictions of WidgetUtil::invokeClosure.
 
1.0.6 (2018-03-01)
------------------

 - Rewrite attribute parsing to fix issue of missing non-value attributes.


1.0.5 (2018-01-30)
------------------

 - Prevent MetaPalettes from throwing an error if an palette does not exist.
 - Test build against Contao 4.5.

 
1.0.4 (2018-01-29)
------------------

 - Fix broken tl_content view if supported palette does not exist (core module disabled).
 - Fix old spdx license format.


1.0.3 (2018-01-05)
------------------

 - Make hook/dca listeners public as Contao requires it
 - Support Metapalettes v2.0
 
