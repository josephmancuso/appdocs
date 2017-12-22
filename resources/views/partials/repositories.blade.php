<div class="col-xs-12 col-md-4">
<div class="panel panel-primary">
    <div class="panel-heading">Repositories</div>

        <div class="panel-body">
            
            @foreach($repos as $repo)
                <div class="row">
                    <div class="col-xs-12">
                        <span>{{ $repo['name'] }} </span>
                        
                        <span class="pull-right">
                        
                        @if($repoList->contains('repo_id', $repo['id']))
                            <a href="/home/repo/{{ $repo['id'] }}">
                                <button class="btn btn-primary"><span class="fa fa-pencil"></span> Edit</button>
                            </a>

                            <a href="http://{{ $repo['name']}}.appdoc.test">
                                <button class="btn btn-default"><span class="fa fa-book"></span> Docs</button>
                            </a>
                        @else
                            <a href="/home/repo/add/{{ $repo['id'] }}">
                                <button class="btn btn-success"><span class="fa fa-plus"></span> Add</button> 
                            </a>
                        @endif
                        </span>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
</div>