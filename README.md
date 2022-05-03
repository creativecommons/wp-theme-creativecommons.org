# wp-theme-creativecommons.org

New WordPress theme for Creative Commons website 


## Code of Conduct

[`CODE_OF_CONDUCT.md`](CODE_OF_CONDUCT.md):
> The Creative Commons team is committed to fostering a welcoming community.
> This project and all other Creative Commons open source projects are governed
> by our [Code of Conduct][code_of_conduct]. Please report unacceptable
> behavior to [conduct@creativecommons.org](mailto:conduct@creativecommons.org)
> per our [reporting guidelines][reporting_guide].

[code_of_conduct]: https://opensource.creativecommons.org/community/code-of-conduct/
[reporting_guide]: https://opensource.creativecommons.org/community/code-of-conduct/enforcement/


## Contributing

See [`CONTRIBUTING.md`](CONTRIBUTING.md).


## API Endpoints

**Note:** enable permalinks within the WordPress settings (Settings -> Permalinks) for the following API URLs to work.

The following endpoints are defined in [`inc/filters.php`][filtersphp]:
1. `/wp-json/ccnavigation-header/menu`
2. `/wp-json/ccnavigation-footer/menu`

3. `/wp-json/cc-wpscripts/get`
4. `/wp-json/cc-wpstyles/get`

[filtersphp]: https://github.com/creativecommons/wp-theme-creativecommons.org/blob/master/inc/filters.php

CLI example using [httpie](https://httpie.org/):
```shell
http -aUSERNAME:PASSWORD https://stage.creativecommons.org/wp-json/ccnavigation/menu
 ```
(replace `USERNAME` and `PASSWORD` with appropriate values)


### Related Documentation

- WordPress Developer Resources
  - [REST API Handbook][apihandbook]
    - [Extending the REST API][extendingapi]
    - [Using the REST API][usingapi]

[apihandbook]: https://developer.wordpress.org/rest-api/
[extendingapi]: https://developer.wordpress.org/rest-api/extending-the-rest-api/
[usingapi]: https://developer.wordpress.org/rest-api/using-the-rest-api/


## License

- [`LICENSE`](LICENSE) (Expat/[MIT][mit] License)

[mit]: http://www.opensource.org/licenses/MIT "The MIT License | Open Source Initiative"
