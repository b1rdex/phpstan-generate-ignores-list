# phpstan-generate-ignores-list

Allows to generate phpstan config with ignores list based on phpstan report (some kind of baseline)

Steps to create baseline ignores list:

1. Run phpstan to create errors list file: `vendor/bin/phpstan analyse --memory-limit=-1 -l3 --error-format=json > phpstan-l3.json`. You should note `--error-format=json > phpstan-errors-list.json` here, that's used to produce JSON of errors and put them to file `phpstan-errors-list.json`.
2. Run script to generate phpstan ignores config: `php phpstan-ignore.php phpstan-errors-list.json > phpstan-ignore-config.neon`. You should note `phpstan-errors-list.json` — that's JSON you used on the previous step; and also `phpstan-ignore-config.neon` — that's where generated phpstan config will be written to.
3. Include newly generated config to your main config file — add `phpstan-ignore-config.neon` to `includes` section of your main config. If you don't have a config file, or there is no `includes` section currently, here is the example:
`phpstan.neon`:
```
includes:
    - phpstan-ignore-config.neon
```

That's it!
