<article class="media">
    <div class="media-content">
        <div class="content">
            <p>
                <strong>
                    <a href="{{ route('files.show',$file) }}" class="has-text-primary">{{ $file->title }}</a>
                </strong>
                <br>
                {{ $file->overview_short }}
            </p>
        </div>
        <div class="level">
            {{ $links }}
        </div>
    </div>
</article>