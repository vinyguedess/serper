[![Travis](https://img.shields.io/travis/rust-lang/rust.svg)]()

# SERPer
App responsible for returning Google, Bing and other SERPs term's search results.

## Installation
```bash
    composer install
```

## Testing
```bash
    composer run test
```

## Usage
* **GET** /
    * Homepage with information about application
* **GET** /search
    * **term** variable defines term to be searched
    * **domain** variable defines which domain should bring further information

## Implementation

### PHP
```php
    $word = str_replace(' ', '+', "Palavra a ser pesquisa");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "serper.herokuapp.com/search?term={$word}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    var_dump($response);
```

### Typescript/Javascript
```javascript
    import * as request from 'request';

    let word = 'Palavra a ser pesquisada', results;
    request
        .get(`http://serper.herokuapp.com/search?term=${word}`)
	.on('data', data => results = data)
	.on('end', () => {
	    results = JSON.parse(results.toString());
            console.log(results);
	});
```
