@extends('account.layouts.default')

@section('account.content')
    

    <h1 class="title">Sell a file</h1>
    {{-- <form action="{{ route('account.files.store',$file) }}" class="dropzone" enctype="multipart/form-data">@csrf</form> --}}


    <form action="{{ route('account.files.store',$file) }}" method="POST" class="form">

         @csrf

        {{-- <input type="hidden" name="uploads" value="{{ $file->id }}"> --}}

        <div class="field">
            <div id="file" class="dropzone" name="file"></div>
            @if($errors->has('uploads'))
                <p class="help is-danger">{{ $errors->first('uploads') }}</p>
            @endif
        </div>

        
        <div class="field">
            <label for="title" class="label">Title</label>
            <p class="control">
                <input type="text" class="input {{$errors->has('title') ? 'is-danger' : '' }}" name="title" id="title">
            </p>
            @if($errors->has('title'))
                <p class="help is-danger">{{ $errors->first('title') }}</p>
            @endif
        </div>

        <div class="field">
            <label for="overview_short" class="label">Overview short</label>
            <p class="control">
                <input type="text" class="input {{$errors->has('overview_short') ? 'is-danger' : '' }}" name="overview_short" id="overview_short">
            </p>
            @if($errors->has('overview_short'))
                <p class="help is-danger">{{ $errors->first('overview_short') }}</p>
            @endif
        </div>

        <div class="field">
            <label for="price" class="label">Price (P)</label>
            <p class="control">
                <input type="text" class="input {{$errors->has('price') ? 'is-danger' : '' }}" name="price" id="price">
            </p>
            @if($errors->has('price'))
                <p class="help is-danger">{{ $errors->first('price') }}</p>
            @endif
        </div>

        <div class="field">
            <label for="overview" class="label">Overview</label>
            <p class="control">
                <textarea name="overview" id="overview" class="textarea {{$errors->has('overview') ? 'is-danger' : '' }}"></textarea>
            </p>
            @if($errors->has('overview'))
                <p class="help is-danger">{{ $errors->first('overview') }}</p>
            @endif
        </div>

        <div class="field is-grouped">
            <p class="control">
                <button class="button is-primary">Submit</button>
            </p>
            <p>We'll review your file before it goes live.</p>
        </div>
    </form>

    
@endsection

@section('scripts')
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script> --}}

        <script>
            $(document).ready(function(){ 
                var drop = new Dropzone('#file', { 
                    createImageThumbnails : false,
                    addRemoveLinks : true,
                    url: '{{ route("upload.store", $file) }}',
                    headers : {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    }); 

                @foreach($file->uploads()->hasNotApproved() as $upload)
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