{if $companyData.socials.facebook != ''}
<div id="facebook" class="col-xs-12 col-sm-4 col-lg-4 block">
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.4";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
    <div id="follow">
        <div class="fb-page" data-href="{$companyData.socials.facebook}" data-width="480" data-height="360" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false">
            <div class="fb-xfbml-parse-ignore">
                <blockquote cite="{$companyData.socials.facebook}">
                    <a href="{$companyData.socials.facebook}">{$companyData.name}</a>
                </blockquote>
            </div>
        </div>
    </div>
</div>
{/if}