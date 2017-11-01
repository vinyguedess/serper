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
* **GET** /search
    * URL: **term** variable defines term to be searched

## Implementation

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
