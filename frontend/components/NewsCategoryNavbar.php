
<style>
    .news_nav_pills{
        padding-left: .65rem;
        padding-top: 1.05rem;
        padding-bottom: 1.05rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        width: 100%;
        background-color: #000;
    }
    .news_nav_pills>ul{
        align-items: center;
    }
    .news_nav_pills>ul>li{
        color: white;
        padding-right: 1.2rem;
    }
    .news_nav_pills>ul>li>a {
        color: white;
        font-size: .82rem;
        font-weight: 900;
    }
    .news_nav_pills>ul>li>a:hover {
        color: #fe4d55;
        font-size: .82rem;
        font-weight: 900;
    }
    .news_nav_pills>ul>li>.active {
        color: #fe4d55;
        font-size: .82rem;
        font-weight: 900;
    }
    .news_nav_pills_brand h2{
        font-size: 2.3rem;
        font-weight: 900;
        padding-right: 2rem;
    }

    @media screen and (max-width: 768px){
        .news_nav_pills{
            margin-left: auto;
            margin-right: auto;
            width: 96%;
        }
    }
</style>

<div class="row news_nav_pills noselect">
    <ul class="nav nav-pills">
        <li class="news_nav_pills_brand"><h2>3Music News</h2></li>
        <li><a class="news_cat_nav_link <?php if(isset($news_lts_active)){ echo $news_lts_active; } ?>" href="<?php echo SECTION_PATH.'news/'; ?>">Latest</a></li>
        <li><a class="news_cat_nav_link <?php if(isset($news_ent_active)){ echo $news_ent_active; } ?>" href="<?php echo SECTION_PATH.'news/entertainment'; ?>">Entertainment</a></li>
        <li><a class="news_cat_nav_link <?php if(isset($news_spt_active)){ echo $news_spt_active; } ?>" href="<?php echo SECTION_PATH.'news/sports'; ?>">Sports</a></li>
        <li><a class="news_cat_nav_link <?php if(isset($news_fas_active)){ echo $news_fas_active; } ?>" href="<?php echo SECTION_PATH.'news/fashion_lifestyle'; ?>">Fashion & Lifestyle</a></li>
        <li><a class="news_cat_nav_link <?php if(isset($news_cul_active)){ echo $news_cul_active; } ?>" href="<?php echo SECTION_PATH.'news/culture'; ?>">Culture</a></li>
    </ul>
</div>