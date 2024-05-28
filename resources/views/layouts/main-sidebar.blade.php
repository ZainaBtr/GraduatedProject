<div class="container-fluid">
    <div class="row">
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg" style="overflow: scroll">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">
        
                    <li>
    <a href="{{ url('/dashboard') }}">
        <div class="pull-left"><i class="ti-home"></i><span class="right-nav-text">Home Page</span>
        </div>
        <div class="clearfix"></div>
    </a>
</li>

                    <!-- Years & Specializations-->
                  
                     <!-- FavoriteServices-->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Favoriteservices">
                            <div class="pull-left"><i class="ti-heart"></i><span
                                    class="right-nav-text">FavoriteServices</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Favoriteservices" class="collapse" data-parent="#sidebarnav">
                            <li><a href="">listFavoriteservices</a></li>

                        </ul>
                    </li>
                     <!-- Advertisements-->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Advertisements">
                            <div class="pull-left"><i class="ti-announcement"></i><span
                                    class="right-nav-text">Advertisements</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Advertisements" class="collapse" data-parent="#sidebarnav">
                            <li><a href="">listAdvertisements</a></li>

                        </ul>
                    </li>
                    
                     <!-- Saved advertisements-->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Savedadvertisements">
                            <div class="pull-left"><i class="ti-bookmark"></i><span
                                    class="right-nav-text">Savedadvertisements</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Savedadvertisements" class="collapse" data-parent="#sidebarnav">
                            <li><a href="">listSavedAdvertisements</a></li>

                        </ul>
                    </li>
                    
                     <!-- Reports & Statistics-->
                     <li>
                        <a href="javascript:void(0);" data-toggle="collapse" data-target="#Reports&Statistics">
                            <div class="pull-left"><i class="ti-comment-alt"></i><span
                                    class="right-nav-text">Reports&Statistics</span></div>
                            <div class="pull-right"><i class="ti-plus"></i></div>
                            <div class="clearfix"></div>
                        </a>
                        <ul id="Reports&Statistics" class="collapse" data-parent="#sidebarnav">
                            <li><a href="">listReports&Statistics</a></li>

                        </ul>
                    </li>
                    
                    

                  
                </ul>
            </div>
        </div>

        