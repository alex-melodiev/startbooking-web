@extends('template')

@section('main')
  <div class="container margin-top40 mb30">
      @include('listing.sidebar')
      
      <div class="col-md-9">
        <form id="img_form" enctype='multipart/form-data' method="post" action="{{url('listing/'.$result->id.'/'.$step)}}" class='signup-form login-form' accept-charset='UTF-8'>
          
          <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 mb20">
              <input class="field form-control" id="photo_file" name="photos[]" type="file" value="fileee" multiple="">
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 mb20">
              <button type="submit" class="btn btn-large btn-primary next-section-button">
                {{trans('messages.listing_description.upload')}}
              </button>
            </div>
          </div>
            </div>
          </div>
          </div>
        </div>
        </form>
        <div class="row">
          <div id="photo-list-div" class="col-md-12 l-pad-none min-height-div">
            <?php
              $serial = 0;
            ?>
            @foreach($photos as $photo)
            <?php
              $serial++;
            ?>
              <div class="col-md-4 margin-top10" id="photo-div-{{$photo->id}}">
                <div class="room-image-container200" style="background-image:url({{url('public/images/property/'.$photo->property_id.'/'.$photo->photo)}});"> 

                  @if($photo->cover_photo == 0)
                  <a class="photo-delete" href="javascript:void(0)" data-rel="{{$photo->id}}"><p class="photo-delete-icon"><i class="fa fa-trash-o"></i></p></a>
                  @endif

                </div>
                <div class="margin-top5">
                  <textarea data-rel="{{$photo->id}}" class="form-control photo-highlights" placeholder="{{trans('messages.listing_description.what_are_the_highlight')}}">{{@$photo->message}}</textarea>
                </div>

                <div class="row">
                  <div class="col-md-6 col-xs-12">
                    <label for="sel1">{{trans('messages.listing_description.serial')}}</label>
                    <input type="text" image_id="{{$photo->id}}" property_id = "{{$result->id}}" id="serial" class="form-control serial" name="serial" value="{{$photo->serial}}">
                  </div>
                <div class="col-md-6 col-xs-12">
                  @if($photo->cover_photo == 0)
                  <label for="sel1">{{trans('messages.listing_description.cover_photo')}}</label>
                  <select class="form-control photoId" id="photoId">
                    <option value="Yes" <?= ($photo->cover_photo == 1 ) ? 'selected' : '' ?> image_id="{{$photo->id}}" property_id = "{{$result->id}}">{{trans('messages.listing_description.yes')}}</option>
                    <option value="No" <?= ($photo->cover_photo == 0 ) ? 'selected' : '' ?> image_id="{{$photo->id}}" property_id = "{{$result->id}}">{{trans('messages.listing_description.no')}}</option>
                  </select>
                  @endif
                   </div>
                </div>

                @if($serial % 3 == 0)
                <div style="clear:both;">&nbsp;</div>
                @endif

              </div>
            @endforeach
          </div>
          <div class="col-md-12 col-xs-12">
            <span class="text-danger display-off" id='photo'>{{ trans('messages.reviews.this_field_is_required') }} 
          </div>
        </div>

        <div style="clear:both;"></div>
        <div class="col-md-12 mrg-top-25 l-pad-none">
          <div class="col-md-10 col-sm-6 col-xs-6 l-pad-none text-left">
              <a data-prevent-default="" href="{{ url('listing/'.$result->id.'/amenities') }}" class="btn btn-large btn-primary">{{trans('messages.listing_description.back')}}</a>
          </div>
          <div class="col-md-2 col-sm-6 col-xs-6 text-right">
            <a href="{{url('listing/'.$result->id.'/pricing')}}" class="btn btn-large btn-primary next-section-button">
             {{trans('messages.listing_basic.next')}} 
            </a>
          </div>
        </div>
      </div>

        
      </div>
      
    </div>
@push('scripts')
  <script type="text/javascript">
    var gl_photo_id = 0;
    $(document).on('submit', '#photo-form', function(e){
      e.preventDefault();
      $('#photo').hide();
      var dataURL = '{{url("add_photos/$result->id")}}';
      var form_data = new FormData(this);
      var photo_file = $('#photo_file').val();
      if(photo_file != ''){
        page_loader_start();
        $.ajax({
          url: dataURL,
          data: form_data,
          type: 'post',
          async: false,
          dataType: 'json',
          processData: false,
          contentType: false,
          success: function (result) {
            if(result.status){
              var photo_url = '{{url("images/rooms/$result->id")}}'+'/'+result.photo_name;
              var photo_div = '<div class="col-md-4 margin-top10" id="photo-div-'+result.photo_id+'">'
                                +'<div class="room-image-container200" style="background-image:url('+photo_url+');">'
                                +'<a class="photo-delete" href="#" data-rel="'+result.photo_id+'"><p class="photo-delete-icon"><i class="fa fa-trash-o"></i></p></a>'
                                +'</div>'
                                +'<div class="margin-top5">'
                                  +'<textarea data-rel="'+result.photo_id+'" class="form-control photo-highlights" placeholder="'+"{{ trans('messages.lys.highlights_photo') }}"+'"></textarea>'
                                +'</div>'
                              +'</div>';
              $('#photo-list-div').append(photo_div);
            }
            else
              $('#photo').show();

          },
          error: function (request, error) {
            // This callback function will trigger on unsuccessful action
            show_error_message('Det har oppstått nettverksfeil vennligst prøv igjen');
          }
        });
        $('#photo_file').val('');
        page_loader_stop();
      }
    });
    
    $(document).on('click', '.photo-delete', function(e){
      e.preventDefault();
      gl_photo_id = $(this).attr('data-rel');
      var con = bootbox.confirm("{{ __('messages.jquery_validation.are_you_sure_to_delete') }}", location_image_upload);


    });
    $(document).on('focusout', '.photo-highlights', function(e){
      var dataURL = '{{url("listing/$result->id/photo_message")}}';
      var photo_id = $(this).attr('data-rel');
      var messages = $(this).val();
      $.ajax({
          url: dataURL,
          data: {'photo_id':photo_id, 'messages':messages},
          type: 'post',
          async: false,
          dataType: 'json',
          success: function (result) {

          },
          error: function (request, error) {
            // This callback function will trigger on unsuccessful action
            show_error_message('Det har oppstått nettverksfeil vennligst prøv igjen');
          }
        });
    })
    
    function location_image_upload(result){
      if(result){
        var dataURL  = '{{url("listing/$result->id/photo_delete")}}';
        var photo_id = gl_photo_id;
        page_loader_start();
        $.ajax({
          url: dataURL,
          data: {'photo_id':photo_id},
          type: 'post',
          async: false,
          dataType: 'json',
          success: function (result) {
            if(result.success){
              $('#photo-div-'+photo_id).remove();
            }
          },
          error: function (request, error) {
            // This callback function will trigger on unsuccessful action
            console.log(error);
          }
        });
        page_loader_stop();
      }
    }


    $(document).on('change', '#photoId', function(ev){
      var dataURL      = '{{url("listing/photo/make_default_photo")}}';
      var option_value = $(this).val();
      var photo_id     = $('option:selected', this).attr('image_id');
      var property_id  = $('option:selected', this).attr('property_id'); 
       page_loader_start();
      $.ajax({
          url: dataURL,
          data: {'photo_id':photo_id, 'property_id':property_id, 'option_value':option_value},
          type: 'post',
          async: false,
          dataType: 'json',
          success: function (result) {
            location.reload();
          }
        });
        page_loader_stop();

     });

    $(document).on('change', '.serial', function(ev){
      var dataURL = '{{url("listing/photo/make_photo_serial")}}';
      var serial = $(this).val();
      var id     = $(this).attr('image_id');
      
      $.ajax({
          url: dataURL,
          data: {'id':id, 'serial':serial},
          type: 'post',
          async: false,
          dataType: 'json',
          success: function (result) {
            location.reload();
          }
        });

     });

  </script>
@endpush
@stop

@section('validation_script')

<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<script type="text/javascript">
  $(document).ready(function () {

            $('#img_form').validate({
                rules: {
                    'photos[]': {
                        required:true,
                        accept: "image/jpg,image/jpeg,image/png,image/gif"
                    }
                },
                messages: {
                    'photos[]': {
                        accept: "{{ __('messages.jquery_validation.image_accept') }}",
                    }
                } 
            });

        });
</script>
@endsection