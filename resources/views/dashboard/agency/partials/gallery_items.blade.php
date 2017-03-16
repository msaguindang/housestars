@if(isset($data['gallery']))
 @php ($chunked_gallery = array_chunk($data['gallery'],3))
  @foreach ($chunked_gallery as $index => $gallery)
    <div class="item {{ ($index == 0 ? 'active' : '') }}">
      @foreach($gallery as $item)
        <div class="col-xs-4">
          <a class="remove-photo" href="javascript:void(0);" data-id="{{$item['id']}}" data-filename="{{$item['url']}}" data-token="{{ csrf_token() }}">
            <i class="fa fa-times" aria-hidden="true" id="close"></i>
          </a>
          <img src="{{ url($item['url']) }}" alt="{{ $item['url'] }}" style="width:140px; height:140px; "> 
        </div>
      @endforeach
    </div>
  @endforeach
@endif