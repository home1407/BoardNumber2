@section('script')
<script type="text/javascript">
  Dropzone.options.dropzone = {
      addRemoveLinks: true,
      removedfile: function(file) {
              var name = file.upload.filename;
              var fileid = file.upload.id;
              $.ajax({
                  headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          },
                  type: 'DELETE',
                  url: '/attachments/'+fileid,
                  data: {filename: name},
                  success: function (data){
                      //console.log("File has been successfully removed!!");
                      alert(data + 'has been successfully removed!!');
                  },
                  error: function(e) {
                      //console.log(e);
                      alert(e);
                  }});
                  var fileRef;
                  return (fileRef = file.previewElement) != null ? 
                  fileRef.parentNode.removeChild(file.previewElement) : void 0;
      },    
      success: function(file, response) {
          //alert(response.filename);
          file.upload.id = response.id;
          //값은 json으로 받은 response의 id값
          $("<input>", {type:'hidden', name:'attachments[]', value:response.id}).appendTo($('#store'));
      },
      error: function(file, response){
         return false;
      }
  }
</script>
@endsection