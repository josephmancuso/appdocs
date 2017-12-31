@extends('dashboard.base')

@section('content')
    <h3 style="margin-left:23px;">{{ $repoType }}</h3>
    @include('partials.can-create-repo')
    <hr>
    <div style="margin-top:20px;">
        <div class="container">
            <!-- Repository Row -->
            
            @if(!isset($organizations)) 
                <!-- show public or private repos -->
                @foreach($repos as $repo)
                    <div class="row">
                        <div class="col-md-6">
                            <h4><i class="fa fa-book"></i> {{ $repo['name'] }}</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            
                                @if($repoList->contains('repo_id', $repo['id']))
                                    <a href="/home/repo/{{ $repo['id'] }}">
                                        <button class="btn btn-primary"><span class="fa fa-pencil"></span> Edit</button>
                                    </a> 
                                    
                                    @foreach($repoList as $siteRepository)
                                        @if ($siteRepository->repo_id == $repo['id'])
                                            <a href="http://{{ $siteRepository->name }}.{{ env('SUBDOMAIN_URL') }}" target="_blank">
                                                <button class="btn btn-default"><span class="fa fa-book"></span> Docs</button>
                                            </a>
                                        @endif
                                    @endforeach
                                
                                @else
                                    @if(Auth::user()->canCreateRepos())
                                        <a href="/home/repo/add/{{ $repo['id'] }}">
                                            <button class="btn btn-success"><span class="fa fa-plus"></span> Add</button> 
                                        </a>
                                    @else
                                        <p>
                                            <a href="/settings#/subscription">
                                                <button class="btn btn-danger">Limited Reached. Click To Upgrade</button>
                                            </a>
                                        </p>
                                    @endif
                                @endif
                            
                        
                        </div>
                        
                        <div class="col-md-12">
                            <hr>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- show organization repositories -->
                @foreach($organizations as $organization => $repos)
                    <h3>{{ $organization }} Organization</h3>
                    <hr>

                    @foreach($repos as $repo)
                        <div class="row">
                            <div class="col-md-6">
                                <h4><i class="fa fa-book"></i> {{ $repo['name'] }}</h4>
                            </div>
                            <div class="col-md-6 text-right">
                            
                                
                                    @if($repoList->contains('repo_id', $repo['id']))
                                        <a href="/home/repo/{{ $repo['id'] }}">
                                            <button class="btn btn-primary"><span class="fa fa-pencil"></span> Edit</button>
                                        </a> 
                                        
                                        @foreach($repoList as $siteRepository)
                                            @if ($siteRepository->repo_id == $repo['id'])
                                                <a href="http://{{ $siteRepository->name }}.{{ env('SUBDOMAIN_URL') }}" target="_blank">
                                                    <button class="btn btn-default"><span class="fa fa-book"></span> Docs</button>
                                                </a>
                                            @endif
                                        @endforeach
                                    
                                    @else
                                        @if(Auth::user()->canCreateRepos())
                                            <a href="/home/repo/add/{{ $repo['id'] }}">
                                                <button class="btn btn-success"><span class="fa fa-plus"></span> Add</button> 
                                            </a>
                                        @else
                                            <p>
                                                <a href="/settings#/subscription">
                                                    <button class="btn btn-danger">Limited Reached. Click To Upgrade</button>
                                                </a>
                                            </p>
                                        @endif
                                    @endif
                                
                            
                            </div>
                            
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
@endsection