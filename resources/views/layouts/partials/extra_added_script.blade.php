<script>
  function myFunction() {
    var copyText = document.getElementById("myInput");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");

    $('#address_copied').css('display', 'block');
  }
</script>

<script>
  function copyAddress(inputId, addressCopied) {
    var copyText = document.getElementById(inputId);
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");

    $('#addressCopied').css('display', 'block');

  }

  function deleteImage(image){
    document.getElementById(image).style.display = "block";
  }

  function cancleImage(image){
    document.getElementById(image).style.display = "none";
  }
</script>


<script>
  $(document).ready(function(){

    $("#upload").click(function(){
      $('#uploading').css('display', 'block');
    });


    $("input").change(function(){ 
      $('#upload').css('display', 'block');
      $('#uploaded_image').css('display', 'none');
      $('#copy_text').css('display', 'none');
      $('#address_copied').css('display', 'none');
    });

  $('#upload_form').on('submit', function(event){

    event.preventDefault();
    $.ajax({
    url:"{{ route('ajaxupload.action') }}",
    method:"POST",
    data:new FormData(this),
    dataType:'JSON',
    contentType: false,
    cache: false,
    processData: false, 
    success:function(data)
    {
      $('#message').css('display', 'block');
      $('#upload').css('display', 'none');
      $('#copy_text').css('display', 'block');
      $('#uploaded_image').css('display', 'block');
      $('#message').html(data.message);
      $('#message').addClass(data.class_name);
      $('#uploaded_image').html(data.uploaded_image);
      $('#myInput').val(data.image_name);
      $('#uploading').css('display', 'none');
    }
    })
  });

  });
</script>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
  tinymce.init({
    selector: 'textarea.my-editor',
    height: 500,
    menubar: false,
    allow_script_urls: true,
    relative_urls: false,
    plugins: [
      'advlist autolink lists link image charmap print preview anchor media',
      'searchreplace visualblocks code fullscreen',
      'insertdatetime media table paste code wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
    'bold italic backcolor | alignleft aligncenter ' +
    'alignright alignjustify | bullist numlist outdent indent | ' +
    'removeformat | image | media',
    content_css: '//www.tiny.cloud/css/codepen.min.css'
  });
</script>


<script type="text/javascript">

  $(document).ready(function(){
  
  var _token = $('input[name="_token"]').val();

  load_data('', _token);

  function load_data(id="", _token)
  {
    $.ajax({
    url:"{{ route('loadmore.load_data') }}",
    method:"POST",
    data:{id:id, _token:_token},
    success:function(data)
    {
      $('#load_more_button').remove();
      $('#post_data').append(data);
    }
    })
  }

  $(document).on('click', '#load_more_button', function(){
    var id = $(this).data('id');
    $('#load_more_button').html('<b>Loading...</b>');
    load_data(id, _token);
  });

  });

</script>
