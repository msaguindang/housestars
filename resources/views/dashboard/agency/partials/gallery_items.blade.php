@if(isset($data['gallery']))
 @php ($chunked_gallery = array_chunk($data['gallery'],3))
  @foreach ($chunked_gallery as $index => $gallery)
    <div class="item {{ ($index == 0 ? 'active' : '') }}">
      @foreach($gallery as $item)
        <div class="col-xs-4 img-item-wrapper">
          <a class="remove-photo" href="javascript:void(0);" data-id="{{$item['id']}}" data-filename="{{$item['url']}}" data-token="{{ csrf_token() }}">
            <i class="fa fa-times" aria-hidden="true" id="close"></i>
          </a>
          <img class='img-thumbnail img-item' id="img-{{$item['id']}}" draggable="true" ondragstart="drag(event);" src="{{ url($item['url']) }}" data-src="{{ url($item['url']) }}" alt="Gallery image"> 
          <!-- style="width:100%; height:140px;" -->
        </div>
      @endforeach
    </div>
  @endforeach
@endif

