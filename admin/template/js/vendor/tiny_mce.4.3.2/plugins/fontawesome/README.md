# tinymce-plugin-fontawesome
A plugin that lets you insert FontAwesome icons via TinyMCE.


### Instructions
- Make sure you have FontAwesome loaded on the page that contains TinyMCE. 
- Copy the fontawesome folder into your TinyMCE plugins folder.
- Add this to your TinyMCE script:

    ```js
    tinymce.init({
        ...
        plugins: 'fontawesome'
        ...
        extended_valid_elements: '+span[*],+i[*]'
        ...
        toolbar: 'fontawesome';
        ...
		content_css: '//netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css';
		...
    });
    ```
