# Alfred DeepL Translation Workflow

[DeepL.com](https://www.deepl.com/) is a great translation service.
It still provides better translations experience than the other popular translation providers.
This workflow integrates the [octfx/DeepLy](https://github.com/m9dfukc/DeepLy) PHP package into Alfred.

**IMPORTANT**: This workflow requires a (free) [Api Key from DeepL](https://www.deepl.com/en/pro-api?cta=header-pro/) to work! 


## Importing a Workflow

Simply install the DeepL workflow by double-clicking the workflow file. You can add the workflow to a category, then click "Import" to finish importing. You'll now see the workflow listed in the left sidebar of your Workflows preferences pane.

Once imported, open the workflow settings (the x in the upper right corner), add your Deepl Api Key and set your default translation targets. The trick is to add your usual source language to the target languages as well, this enables you to easily translate back and forth.


## Usage

To activate this workflow use the default keyword _"dl"_, enter the passage you wanna get translated. Source language will be inferred automatically, the preferred destination language can be set in the workflow. You can also enforce the target language by using the `>` symbol – for example `dl today will be nice weather > fr` or for more than one target language `dl will it rain today? > fr nl`.

Source and destination language codes available
```
de, en, fr, es, it, ja, nl, pl, pt, ru, zh
```

**Tip:** Use _⏎_&nbsp; to copy translated text to your clipboard. Use _⌘_ + _⏎_&nbsp; to show long sentences as screen overlay and _⎋_&nbsp; to go back. Send any system wide text selection via the hotkey combo _^⌥⌘D_&nbsp; to DeeplTranslate.


## Requirements

This library requires PHP 7.2 or higher, the mbstring and the Json extension installed as your default php environment `/usr/bin/php`. Future versions of >= macOS Monterey 12.0.0 won't have PHP preinstalled you might need to [install PHP yourself](https://www.php.net/manual/en/install.macosx.php). Also check this github issue [here](https://github.com/m9dfukc/deepl-alfred-workflow/issues/2). 
This workflow requires that you have an DeepL Api Key. If you do not have one, now is the time ... vist [DeepL-com](https://www.deepl.com/) to request an API key.


## Disclaimer

DeepL is a product from DeepL GmbH. More info: [deepl.com/publisher.html](https://www.deepl.com/publisher.html)

This package has been heavily inspired by Chris Konnertz [DeepLy PHP package](https://github.com/chriskonnertz/DeepLy) and uses a [fork](https://github.com/m9dfukc/DeepLy) of a [fork](https://github.com/octfx/DeepLy) to interface with DeepL via PHP.


## Source code

The source code for the workflow is available in the `src` folder and will require PHP 7.2 or higher with the mbstring and json extensions.


### Source Code Dependencies

Install all dependencies through [Composer](https://getcomposer.org/):

```
cd src;
composer install;
```