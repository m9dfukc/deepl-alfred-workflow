# Alfred 2 DeepL Translation Workflow

[DeepL.com](https://www.deepl.com/) is a great, new translation service.
It provides better translations compared to other popular translation engines.
This workflow integrates the [chriskonnertz/DeepLy](https://github.com/chriskonnertz/DeepLy) PHP package into Alfred. The package currently implements the client to interact with DeepL via their _undocumented_ API.


## Importing a Workflow

Simply install the DeepL workflow by double-clicking the workflow file. You can add the workflow to a category, then click "Import" to finish importing. You'll now see the workflow listed in the left sidebar of your Workflows preferences pane.

Once imported, take a quick look at the workflow settings and setup what keyword you want to use.


## Usage

To activate this workflow use the default keyword _"dl"_, enter the passage you wanna get translated. Source language will be inferred automatically, the preferred destination language can be set in the workflow. You can also enforce the destination language by using the _">"_ symbol – f.e. `dl {passage} > fr`. Following source and destination language codes are available `DE, EN, FR, ES, IT, NL, PL`.


## Source code

The source code for the workflow is available in the `src` folder and will require PHP >= 5.6 with the cURL extension.


### Source Code Dependencies

Install all dependencies through [Composer](https://getcomposer.org/):

```
cd src;
composer install;
```

#### Utilized PHP libraries

> [chriskonnertz/DeepLy](https://github.com/chriskonnertz/DeepLy)
> [SteveJobzniak/AlfredWorkflows](https://github.com/SteveJobzniak/AlfredWorkflows)
