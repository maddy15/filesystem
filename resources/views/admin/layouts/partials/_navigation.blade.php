<aside class="menu">
    <p class="menu-label">Manage Files</p>
    <ul class="menu-list">
        @can('edit files')
            <li>
                <a href="{{ route('admin.files.new.index') }}">Approved new files</a>
            </li>
        @endcan
        @can('delete files')
            <li>
                <a href="{{ route('admin.files.updated.index') }}">Approved updated files</a>
            </li>
        @endcan
    </ul>
</aside>