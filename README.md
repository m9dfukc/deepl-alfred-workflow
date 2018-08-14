# Alfred DeepL Translation Workflow

[DeepL.com](https://www.deepl.com/) is a great, new translation service.
It provides better translations compared to other popular translation engines.
This workflow integrates the [chriskonnertz/DeepLy](https://github.com/chriskonnertz/DeepLy) PHP package into Alfred.


> **IMPORTANT STATEMENT**: This workflow is currently not working as Deepl.com has changed its API, [see issue#14](https://github.com/m9dfukc/deepl-alfred-workflow/issues/14)! There is a new version of [DeepLy](https://github.com/chriskonnertz/DeepLy) on the horizon which will allow using this workflow with [DeepL Pro](https://www.deepl.com/en/pro.html) - I might update this workflow when the time comes.


## Importing a Workflow

Simply install the DeepL workflow by double-clicking the workflow file. You can add the workflow to a category, then click "Import" to finish importing. You'll now see the workflow listed in the left sidebar of your Workflows preferences pane.

Once imported, take a quick look at the workflow settings and setup what keyword you want to use.


## Usage

To activate this workflow use the default keyword _"dl"_, enter the passage you wanna get translated. Source language will be inferred automatically, the preferred destination language can be set in the workflow. You can also enforce the target language by using the `>` symbol – for example `dl today will be nice weather > fr` or for more than one target language `dl will it rain today? > fr nl`.

Source and destination language codes available
```
de, en, fr, es, it, nl, pl
```

**Pro tip:** Use _⏎_&nbsp; to copy translated text to your clipboard. Use _⌘_ + _⏎_&nbsp; to show long sentences as screen overlay and _⎋_&nbsp; to go back. Send any system wide text selection via the hotkey combo _^⌥⌘D_&nbsp; to DeeplTranslate.


## Requirements

This workflow requires PHP >= 5.6 with the cURL extension as your default php environment `/usr/bin/php`. Therefore macOS 10.12 is recommended as minimum if you don't want to [jump through hoops](https://github.com/m9dfukc/deepl-alfred-workflow/issues/2).  


## Disclaimer

This workflow currently interacts with DeepL's _undocumented_ and _unofficial_ API.
The API of DeepL.com is free but this might change in the future.

DeepL is a product from DeepL GmbH. More info: [deepl.com/publisher.html](https://www.deepl.com/publisher.html)

This package has been heavily inspired by Chris Konnertz [DeepLy PHP package](https://github.com/chriskonnertz/DeepLy).


## Source code

The source code for the workflow is available in the `src` folder and will require PHP >= 5.6 with the cURL extension.


### Source Code Dependencies

Install all dependencies through [Composer](https://getcomposer.org/):

```
cd src;
composer install;
```


#### Utilized PHP libraries

* [chriskonnertz/DeepLy](https://github.com/chriskonnertz/DeepLy)
* [SteveJobzniak/AlfredWorkflows](https://github.com/m9dfukc/alfred-workflows)
