
@if(!Auth::user()->canCreateRepos())
    <div class="alert alert-danger" role="alert" style="margin-left:23px;"><span>You have reached your limit of 3 public repos on the free plan. Consider upgrading to get unlimited public and private repositories</span></div>
@elseif(!Auth::user()->subscribedToPlan(['organization', 'private']))
    <div class="alert alert-warning" role="alert" style="margin-left:23px;"><span>You have {{ Auth::user()->reposLeft() }} public repos left on the free plan. Consider upgrading to get unlimited public and private repositories</span></div>
@endif

