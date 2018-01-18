# mainstreamingtv
PHP SDK for mainstreaming.tv APIs

## Installation

Install the package via composer: `composer require riccardo993/mainstreamingtv`

You need PHP 7 or upper to use this package.

## Usage

In order to use this package you need an API token from the provider and your IP address added in their whitelist.

## Upload a file

In order to perform the file upload process you need to generate a single-use url to which your data is sent.

```php
$output = [
    'error' => null,
    'data' => null
];

try{
    $provider = new Mainstreaming('API_TOKEN');
    $path = $provider->upload()->getSecureUploadPath();

    $output['data'] = [
        'url' => $path
    ];
}catch(\Exception $e){
    $output['error'] = $e->getMessage();
    http_response_code(500);
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($output);
```

Since the API does not provide a return option, you should not use it directly in your form action field but instead in an ajax request.
Once the upload is done, the server response with the video id and store it in the `contentId` variable.


Since the single-use url only lasts for few minutes, you should generate it only when the user is going to upload the file.


With the jQuery File Upload library you can do this in this way:

```js
$('#fileupload').fileupload({
    submit: function(e, data) {
        var $that = $(this);

        $.post('/video/generate-action', function(result) {
            data.url = result.data.url; // Set the url
            $that.fileupload('send', data); // Manually perform the sending request
        }).fail(function(result) {
            alert(result.responseJSON.error); // The single-use url could not be created
        });

        return false;
    }
}).bind('fileuploaddone', function (e, data) {
    var id = data.result.contentId; // get your unique video ID
});
```

**We are not going to use chunked upload because it is not working**

### Custom attributes during the upload

You can put lots of field in your form to set file attributes. The commons are the upload directory and the filename.

To get the category ID use the dedicated method.

```html
<input type="hidden" name="title" value="My video" />
<input type="hidden" name="idCategory" value="123456789" />
<input type="file" name="file">
```

## Video status

You can check if your video is ready to be seen or on queue or encoding.

```php
$status = $provider->video('VIDEO_ID')->getStatus();
```

You get one of these errors:
* queued
* encoding
* ready
* error

If you perform the video status query immediately after the upload, you could get an error because the API does not find your video yet so make sure to perform a check before:
```php
if($video = $provider->video('VIDEO_ID'))
{
  $status = $video->getStatus();
}
```

## Get the upload directory ID

Supposed you have a folder named `My Videos` you can automatically get the ID simply with one command:
```php
$id = $provider->categories()->find('my videos')->getId();
```

If you are not sure that your folder exists you should check it before accessing its method like this:
```php
if($category = $provider->categories()->find('my videos'))
{
  $id = $category->getId();
}
```

**Note that the research is case insensitive**
