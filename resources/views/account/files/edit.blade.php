@extends('account.layouts.default')

@section('account.content')

    <h1 class="title">Make changes to {{ $file->title }}</h1>

    

    @if($approval)
        @include('account.files.partials._changes',compact('approval','file'))
    @endif

    <form action="{{ route('account.files.update',$file) }}" method="POST" class="form">
        @csrf
        {{ method_field('PATCH') }}

        <input type="hidden" name="live" value={{ 0 }}>

        <div class="field"  id="fileSystem">
            <div id="file" class="dropzone" name="file"></div>
            @if($errors->has('uploads'))
                <p class="help is-danger">{{ $errors->first('uploads') }}</p>
            @endif
        </div>

        <div class="field">
            <p class="control">
                <label for="live" class="checkbox">
                    <input type="checkbox" name="live" id="live" {{ $file->live ? 'checked' : '' }} value="{{ 'checked' ? true : '' }}"> Live
                </label>
            </p>
        </div>

        <div class="field">
            <label for="title" class="label">Title</label>
            <p class="control">
            <input type="text" class="input {{$errors->has('title') ? 'is-danger' : '' }}" name="title" id="title" value="{{ old('title') ? old('title') : $file->title }}">
            </p>
            @if($errors->has('title'))
                <p class="help is-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>

        <div class="field">
            <label for="overview_short" class="label">Overview short</label>
            <p class="control">
                <input type="text" class="input {{$errors->has('overview_short') ? 'is-danger' : '' }}" name="overview_short" id="overview_short" value="{{ old('overview_short') ? old('overview_short') : $file->overview_short }}">
            </p>
            @if($errors->has('overview_short'))
                <p class="help is-danger">{{ $errors->first('overview_short') }}</p>
            @endif
        </div>

        <div class="field">
            <label for="price" class="label">Price (P)</label>
            <p class="control">
                <input type="text" class="input {{$errors->has('price') ? 'is-danger' : '' }}" name="price" id="price" value="{{ old('price') ? old('price') : $file->price }}">
            </p>
            @if($errors->has('price'))
                <p class="help is-danger">{{ $errors->first('price') }}</p>
            @endif
        </div>

        <div class="field">
            <label for="overview" class="label">Overview</label>
            <p class="control">
                <textarea name="overview" id="overview" class="textarea {{$errors->has('overview') ? 'is-danger' : '' }}">{{ old('overview') ? old('overview') : $file->overview }}</textarea>
            </p>
            @if($errors->has('overview'))
                <p class="help is-danger">{{ $errors->first('overview') }}</p>
            @endif
        </div>

        <div class="field is-grouped">
            <p class="control">
                <button class="button is-primary" id="submitButton">Submit</button>
            </p>
            <p>Your files changes maybe subject to review.</p>
        </div>
    </form>
@endsection

@section('scripts')

        <script>
            $(document).ready(function(){ 
                
                var tl = TweenLite.TweenLite;

                tl.to('#fileSystem',1,{opacity:1,transform:'scale(1)',transformOrigin:'0 0'})
                
                var drop = new Dropzone('#file', { 
                    createImageThumbnails : false,
                    addRemoveLinks : true,
                    url: '{{ route("upload.store", $file) }}',
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    }); 

                @foreach($file->uploads as $upload)
                    drop.emit('addedfile',{
                                id : '{{ $upload->id }}',
                                name : '{{ $upload->filename }}',
                                size : '{{ $upload->size }}',
                            });
                @endforeach

                drop.on('success',(file,response) => {
                    file.id = response.id;
                });

                drop.on('removedfile',(file) => {
                    axios.delete('/uploads/{{ $file->identifier }}/upload/' + file.id)
                        .catch((error) =>{
                            drop.emit('addedfile',{
                                id : file.id,
                                name : file.name,
                                size : file.size
                            })
                        })
                });
            });
        </script>
@endsection