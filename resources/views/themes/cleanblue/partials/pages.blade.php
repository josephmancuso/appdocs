<ul class="nav nav-pills nav-stacked">
    @foreach($pages as $key => $page)
        @if (is_array($page))               
            @foreach($page as $title => $files)

                    <button class="accordion">{{ $title }} <span class="fa fa-angle-down"></span></button>
                    
                    <div class="accordion-panel">
                        @foreach($files as $file) 
                            @if(isset($currentVersion))
                                <li role="presentation"><a href="/v/{{ $currentVersion }}/{{ $title}}/{{ str_replace('.md', '', $file) }}">{{ str_replace('.md', '', str_replace('-', ' ', $file)) }}</a></li>
                            @else
                                <li role="presentation"><a href="/docs/{{ $title}}/{{ str_replace('.md', '', $file) }}">{{ str_replace('.md', '', str_replace('-', ' ', $file)) }}</a></li>
                            @endif
                        @endforeach
                    </div>
                
            @endforeach
        @else
            @if(isset($currentVersion))
                <li role="presentation"><a href="/v/{{ $currentVersion }}/{{ str_replace('.md', '', $page) }}">{{ str_replace('.md', '', str_replace('-', ' ', $page)) }}</a></li>
            @else
                <li role="presentation"><a href="/docs/{{ str_replace('.md', '', $page) }}">{{ str_replace('.md', '', str_replace('-', ' ', $page)) }}</a></li>
            @endif
        @endif
    @endforeach
</ul>