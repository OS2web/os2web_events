# OS2Web Events Drupal module

## Module purpose

The aim of to add Events content types and Events search view.

## Additional settings
Settings are available under `admin/config/system/os2web-events`
* **Old events should be** - How to handle the events that are no longer present in the feeds.

## Submodules
### os2web_events_kulturnaut
The aim of to provide import of the events from Kultunaut feed.

**Additional settings**

Settings are available under `/admin/config/system/os2web-kulturnaut`
* **Possible event versions** - allows mapping between imported event version (visible in import URL after _?version=_ prefix) and OS2Web Section and Os2web event categories.
* **Section mappings** - mapping each version with section (only if versions are not empty)
* **Category mappings** - mapping each version with category (only if versions are not empty)


## Install

1. Module is available to download via composer.
    ```
    composer require os2web/os2web_events
    drush en os2web_events
    ```

1. After activation, run cron to trigger the import.

## Update
Updating process for OS2Web Events module is similar to usual Drupal 8 module.
Use Composer's built-in command for listing packages that have updates available:

```
composer outdated os2web/os2web_events
```

## Automated testing and code quality
See [OS2Web testing and CI information](https://github.com/OS2Web/docs#testing-and-ci)

## Contribution

Project is opened for new features and os course bugfixes.
If you have any suggestion or you found a bug in project, you are very welcome
to create an issue in github repository issue tracker.
For issue description there is expected that you will provide clear and
sufficient information about your feature request or bug report.

### Code review policy
See [OS2Web code review policy](https://github.com/OS2Web/docs#code-review)

### Git name convention
See [OS2Web git name convention](https://github.com/OS2Web/docs#git-guideline)
