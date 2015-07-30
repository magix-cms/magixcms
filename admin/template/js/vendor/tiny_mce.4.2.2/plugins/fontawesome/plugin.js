/*!
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of tinyMCE.
 # font awesome for tinyMCE
 # Copyright (C) 2011 - 2015  Gerits Aurelien <aurelien[at]magix-dev[dot]be> - <aurelien[at]magix-cms[dot]com>
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.

 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------
 */
tinymce.PluginManager.requireLangPack('fontawesome');
tinymce.PluginManager.add('fontawesome', function (editor, url) {

    var translate = tinymce.util.I18n.translate;

    var webApplicationIcons = [
        ['adjust'],
        ['anchor'],
        ['archive'],
        ['area-chart'],
        ['arrows'],
        ['arrows-h'],
        ['arrows-v'],
        ['asterisk'],
        ['at'],
        ['automobile'],
        ['balance-scale'],
        ['ban'],
        ['bank'],
        ['bar-chart'],
        ['bar-chart-o'],
        ['barcode'],
        ['bars'],
        ['battery-0'],
        ['battery-1'],
        ['battery-2'],
        ['battery-3'],
        ['battery-4'],
        ['battery-empty'],
        ['battery-full'],
        ['battery-half'],
        ['battery-quarter'],
        ['battery-three-quarters'],
        ['bed'],
        ['beer'],
        ['bell'],
        ['bell-o'],
        ['bell-slash'],
        ['bell-slash-o'],
        ['bicycle'],
        ['binoculars'],
        ['birthday-cake'],
        ['bolt'],
        ['bomb'],
        ['book'],
        ['bookmark'],
        ['bookmark-o'],
        ['briefcase'],
        ['bug'],
        ['building'],
        ['building-o'],
        ['bullhorn'],
        ['bullseye'],
        ['bus'],
        ['cab'],
        ['calculator'],
        ['calendar'],
        ['calendar-check-o'],
        ['calendar-minus-o'],
        ['calendar-o'],
        ['calendar-plus-o'],
        ['calendar-times-o'],
        ['camera'],
        ['camera-retro'],
        ['car'],
        ['caret-square-o-down'],
        ['caret-square-o-left'],
        ['caret-square-o-right'],
        ['caret-square-o-up'],
        ['cart-arrow-down'],
        ['cart-plus'],
        ['cc'],
        ['certificate'],
        ['check'],
        ['check-circle'],
        ['check-circle-o'],
        ['check-square'],
        ['check-square-o'],
        ['child'],
        ['circle'],
        ['circle-o'],
        ['circle-o-notch'],
        ['circle-thin'],
        ['clock-o'],
        ['clone'],
        ['close'],
        ['cloud'],
        ['cloud-download'],
        ['cloud-upload'],
        ['code'],
        ['code-fork'],
        ['coffee'],
        ['cog'],
        ['cogs'],
        ['comment'],
        ['comment-o'],
        ['commenting'],
        ['commenting-o'],
        ['comments'],
        ['comments-o'],
        ['compass'],
        ['copyright'],
        ['creative-commons'],
        ['credit-card'],
        ['crop'],
        ['crosshairs'],
        ['cube'],
        ['cubes'],
        ['cutlery'],
        ['dashboard'],
        ['database'],
        ['desktop'],
        ['diamond'],
        ['dot-circle-o'],
        ['download'],
        ['edit'],
        ['ellipsis-h'],
        ['ellipsis-v'],
        ['envelope'],
        ['envelope-o'],
        ['envelope-square'],
        ['eraser'],
        ['exchange'],
        ['exclamation'],
        ['exclamation-circle'],
        ['exclamation-triangle'],
        ['external-link'],
        ['external-link-square'],
        ['eye'],
        ['eye-slash'],
        ['eyedropper'],
        ['fax'],
        ['feed'],
        ['female'],
        ['fighter-jet'],
        ['file-archive-o'],
        ['file-audio-o'],
        ['file-code-o'],
        ['file-excel-o'],
        ['file-image-o'],
        ['file-movie-o'],
        ['file-pdf-o'],
        ['file-photo-o'],
        ['file-picture-o'],
        ['file-powerpoint-o'],
        ['file-sound-o'],
        ['file-video-o'],
        ['file-word-o'],
        ['file-zip-o'],
        ['film'],
        ['filter'],
        ['fire'],
        ['fire-extinguisher'],
        ['flag'],
        ['flag-checkered'],
        ['flag-o'],
        ['flash'],
        ['flask'],
        ['folder'],
        ['folder-o'],
        ['folder-open'],
        ['folder-open-o'],
        ['frown-o'],
        ['futbol-o'],
        ['gamepad'],
        ['gavel'],
        ['gear'],
        ['gears'],
        ['gift'],
        ['glass'],
        ['globe'],
        ['graduation-cap'],
        ['group'],
        ['hand-grab-o'],
        ['hand-lizard-o'],
        ['hand-paper-o'],
        ['hand-peace-o'],
        ['hand-pointer-o'],
        ['hand-rock-o'],
        ['hand-scissors-o'],
        ['hand-spock-o'],
        ['hand-stop-o'],
        ['hdd-o'],
        ['headphones'],
        ['heart'],
        ['heart-o'],
        ['heartbeat'],
        ['history'],
        ['home'],
        ['hotel'],
        ['hourglass'],
        ['hourglass-1'],
        ['hourglass-2'],
        ['hourglass-3'],
        ['hourglass-end'],
        ['hourglass-half'],
        ['hourglass-o'],
        ['hourglass-start'],
        ['i-cursor'],
        ['image'],
        ['inbox'],
        ['industry'],
        ['info'],
        ['info-circle'],
        ['institution'],
        ['key'],
        ['keyboard-o'],
        ['language'],
        ['laptop'],
        ['leaf'],
        ['legal'],
        ['lemon-o'],
        ['level-down'],
        ['level-up'],
        ['life-bouy'],
        ['life-buoy'],
        ['life-ring'],
        ['life-saver'],
        ['lightbulb-o'],
        ['line-chart'],
        ['location-arrow'],
        ['lock'],
        ['magic'],
        ['magnet'],
        ['mail-forward'],
        ['mail-reply'],
        ['mail-reply-all'],
        ['male'],
        ['map'],
        ['map-marker'],
        ['map-o'],
        ['map-pin'],
        ['map-signs'],
        ['meh-o'],
        ['microphone'],
        ['microphone-slash'],
        ['minus'],
        ['minus-circle'],
        ['minus-square'],
        ['minus-square-o'],
        ['mobile'],
        ['mobile-phone'],
        ['money'],
        ['moon-o'],
        ['mortar-board'],
        ['motorcycle'],
        ['mouse-pointer'],
        ['music'],
        ['navicon'],
        ['newspaper-o'],
        ['object-group'],
        ['object-ungroup'],
        ['paint-brush'],
        ['paper-plane'],
        ['paper-plane-o'],
        ['paw'],
        ['pencil'],
        ['pencil-square'],
        ['pencil-square-o'],
        ['phone'],
        ['phone-square'],
        ['photo'],
        ['picture-o'],
        ['pie-chart'],
        ['plane'],
        ['plug'],
        ['plus'],
        ['plus-circle'],
        ['plus-square'],
        ['plus-square-o'],
        ['power-off'],
        ['print'],
        ['puzzle-piece'],
        ['qrcode'],
        ['question'],
        ['question-circle'],
        ['quote-left'],
        ['quote-right'],
        ['random'],
        ['recycle'],
        ['refresh'],
        ['registered'],
        ['remove'],
        ['reorder'],
        ['reply'],
        ['reply-all'],
        ['retweet'],
        ['road'],
        ['rocket'],
        ['rss'],
        ['rss-square'],
        ['search'],
        ['search-minus'],
        ['search-plus'],
        ['send'],
        ['send-o'],
        ['server'],
        ['share'],
        ['share-alt'],
        ['share-alt-square'],
        ['share-square'],
        ['share-square-o'],
        ['shield'],
        ['ship'],
        ['shopping-cart'],
        ['sign-in'],
        ['sign-out'],
        ['signal'],
        ['sitemap'],
        ['sliders'],
        ['smile-o'],
        ['soccer-ball-o'],
        ['sort'],
        ['sort-alpha-asc'],
        ['sort-alpha-desc'],
        ['sort-amount-asc'],
        ['sort-amount-desc'],
        ['sort-asc'],
        ['sort-desc'],
        ['sort-down'],
        ['sort-numeric-asc'],
        ['sort-numeric-desc'],
        ['sort-up'],
        ['space-shuttle'],
        ['spinner'],
        ['spoon'],
        ['square'],
        ['square-o'],
        ['star'],
        ['star-half'],
        ['star-half-empty'],
        ['star-half-full'],
        ['star-half-o'],
        ['star-o'],
        ['sticky-note'],
        ['sticky-note-o'],
        ['street-view'],
        ['suitcase'],
        ['sun-o'],
        ['support'],
        ['tablet'],
        ['tachometer'],
        ['tag'],
        ['tags'],
        ['tasks'],
        ['taxi'],
        ['television'],
        ['terminal'],
        ['thumb-tack'],
        ['thumbs-down'],
        ['thumbs-o-down'],
        ['thumbs-o-up'],
        ['thumbs-up'],
        ['ticket'],
        ['times'],
        ['times-circle'],
        ['times-circle-o'],
        ['tint'],
        ['toggle-down'],
        ['toggle-left'],
        ['toggle-off'],
        ['toggle-on'],
        ['toggle-right'],
        ['toggle-up'],
        ['trademark'],
        ['trash'],
        ['trash-o'],
        ['tree'],
        ['trophy'],
        ['truck'],
        ['tty'],
        ['tv'],
        ['umbrella'],
        ['university'],
        ['unlock'],
        ['unlock-alt'],
        ['unsorted'],
        ['upload'],
        ['user'],
        ['user-plus'],
        ['user-secret'],
        ['user-times'],
        ['users'],
        ['video-camera'],
        ['volume-down'],
        ['volume-off'],
        ['volume-up'],
        ['warning'],
        ['wheelchair'],
        ['wifi'],
        ['wrench']
    ];
    var handIcons = [
        ['hand-grab-o'],
        ['hand-lizard-o'],
        ['hand-o-down'],
        ['hand-o-left'],
        ['hand-o-right'],
        ['hand-o-up'],
        ['hand-paper-o'],
        ['hand-peace-o'],
        ['hand-pointer-o'],
        ['hand-rock-o'],
        ['hand-scissors-o'],
        ['hand-spock-o'],
        ['hand-stop-o'],
        ['thumbs-down'],
        ['thumbs-o-down'],
        ['thumbs-o-up'],
        ['thumbs-up']
    ];
    var transportationIcons = [
        ['ambulance'],
        ['automobile'],
        ['bicycle'],
        ['bus'],
        ['cab'],
        ['car'],
        ['fighter-jet'],
        ['motorcycle'],
        ['plane'],
        ['rocket'],
        ['ship'],
        ['space-shuttle'],
        ['subway'],
        ['taxi'],
        ['train'],
        ['truck'],
        ['wheelchair']
    ];
    var genderIcons = [
        ['genderless'],
        ['intersex'],
        ['mars'],
        ['mars-double'],
        ['mars-stroke'],
        ['mars-stroke-h'],
        ['mars-stroke-v'],
        ['mercury'],
        ['neuter'],
        ['transgender'],
        ['transgender-alt'],
        ['venus'],
        ['venus-double'],
        ['venus-mars']
    ];
    var fileTypeIcons = [
        ['file'],
        ['file-archive-o'],
        ['file-audio-o'],
        ['file-code-o'],
        ['file-excel-o'],
        ['file-image-o'],
        ['file-movie-o'],
        ['file-o'],
        ['file-pdf-o'],
        ['file-photo-o'],
        ['file-picture-o'],
        ['file-powerpoint-o'],
        ['file-sound-o'],
        ['file-text'],
        ['file-text-o'],
        ['file-video-o'],
        ['file-word-o'],
        ['file-zip-o']
    ];
    var spinnerIcons = [
        ['circle-o-notch'],
        ['cog'],
        ['gear'],
        ['refresh'],
        ['spinner']
    ];
    var formControlIcons = [
        ['check-square'],
        ['check-square-o'],
        ['circle'],
        ['circle-o'],
        ['dot-circle-o'],
        ['minus-square'],
        ['minus-square-o'],
        ['plus-square'],
        ['plus-square-o'],
        ['square'],
        ['square-o']
    ];
    var paymentIcons = [
        ['cc-amex'],
        ['cc-diners-club'],
        ['cc-discover'],
        ['cc-jcb'],
        ['cc-mastercard'],
        ['cc-paypal'],
        ['cc-stripe'],
        ['cc-visa'],
        ['credit-card'],
        ['google-wallet'],
        ['paypal']
    ];
    var chartIcons = [
        ['area-chart'],
        ['bar-chart'],
        ['bar-chart-o'],
        ['line-chart'],
        ['pie-chart']
    ];
    var currencyIcons = [
        ['bitcoin'],
        ['btc'],
        ['cny'],
        ['dollar'],
        ['eur'],
        ['euro'],
        ['gbp'],
        ['gg'],
        ['gg-circle'],
        ['ils'],
        ['inr'],
        ['jpy'],
        ['krw'],
        ['money'],
        ['rmb'],
        ['rouble'],
        ['rub'],
        ['ruble'],
        ['rupee'],
        ['shekel'],
        ['sheqel'],
        ['try'],
        ['turkish-lira'],
        ['usd'],
        ['won'],
        ['yen']
    ];
    var textEditorIcons = [
        ['align-center'],
        ['align-justify'],
        ['align-left'],
        ['align-right'],
        ['bold'],
        ['chain'],
        ['chain-broken'],
        ['clipboard'],
        ['columns'],
        ['copy'],
        ['cut'],
        ['dedent'],
        ['eraser'],
        ['file'],
        ['file-o'],
        ['file-text'],
        ['file-text-o'],
        ['files-o'],
        ['floppy-o'],
        ['font'],
        ['header'],
        ['indent'],
        ['italic'],
        ['link'],
        ['list'],
        ['list-alt'],
        ['list-ol'],
        ['list-ul'],
        ['outdent'],
        ['paperclip'],
        ['paragraph'],
        ['paste'],
        ['repeat'],
        ['rotate-left'],
        ['rotate-right'],
        ['save'],
        ['scissors'],
        ['strikethrough'],
        ['subscript'],
        ['superscript'],
        ['table'],
        ['text-height'],
        ['text-width'],
        ['th'],
        ['th-large'],
        ['th-list'],
        ['underline'],
        ['undo'],
        ['unlink']
    ];
    var directionalIcons = [
        ['angle-double-down'],
        ['angle-double-left'],
        ['angle-double-right'],
        ['angle-double-up'],
        ['angle-down'],
        ['angle-left'],
        ['angle-right'],
        ['angle-up'],
        ['arrow-circle-down'],
        ['arrow-circle-left'],
        ['arrow-circle-o-down'],
        ['arrow-circle-o-left'],
        ['arrow-circle-o-right'],
        ['arrow-circle-o-up'],
        ['arrow-circle-right'],
        ['arrow-circle-up'],
        ['arrow-down'],
        ['arrow-left'],
        ['arrow-right'],
        ['arrow-up'],
        ['arrows'],
        ['arrows-alt'],
        ['arrows-h'],
        ['arrows-v'],
        ['caret-down'],
        ['caret-left'],
        ['caret-right'],
        ['caret-square-o-down'],
        ['caret-square-o-left'],
        ['caret-square-o-right'],
        ['caret-square-o-up'],
        ['caret-up'],
        ['chevron-circle-down'],
        ['chevron-circle-left'],
        ['chevron-circle-right'],
        ['chevron-circle-up'],
        ['chevron-down'],
        ['chevron-left'],
        ['chevron-right'],
        ['chevron-up'],
        ['exchange'],
        ['hand-o-down'],
        ['hand-o-left'],
        ['hand-o-right'],
        ['hand-o-up'],
        ['long-arrow-down'],
        ['long-arrow-left'],
        ['long-arrow-right'],
        ['long-arrow-up'],
        ['toggle-down'],
        ['toggle-left'],
        ['toggle-right'],
        ['toggle-up']
    ];
    var videoPlayerIcons = [
        ['arrows-alt'],
        ['backward'],
        ['compress'],
        ['eject'],
        ['expand'],
        ['fast-backward'],
        ['fast-forward'],
        ['forward'],
        ['pause'],
        ['play'],
        ['play-circle'],
        ['play-circle-o'],
        ['random'],
        ['step-backward'],
        ['step-forward'],
        ['stop'],
        ['youtube-play']
    ];
    var brandIcons = [
        ['500px'],
        ['adn'],
        ['amazon'],
        ['android'],
        ['angellist'],
        ['apple'],
        ['behance'],
        ['behance-square'],
        ['bitbucket'],
        ['bitbucket-square'],
        ['bitcoin'],
        ['black-tie'],
        ['btc'],
        ['buysellads'],
        ['cc-amex'],
        ['cc-diners-club'],
        ['cc-discover'],
        ['cc-jcb'],
        ['cc-mastercard'],
        ['cc-paypal'],
        ['cc-stripe'],
        ['cc-visa'],
        ['chrome'],
        ['codepen'],
        ['connectdevelop'],
        ['contao'],
        ['css3'],
        ['dashcube'],
        ['delicious'],
        ['deviantart'],
        ['digg'],
        ['dribbble'],
        ['dropbox'],
        ['drupal'],
        ['empire'],
        ['expeditedssl'],
        ['facebook'],
        ['facebook-f'],
        ['facebook-official'],
        ['facebook-square'],
        ['firefox'],
        ['flickr'],
        ['fonticons'],
        ['forumbee'],
        ['foursquare'],
        ['ge'],
        ['get-pocket'],
        ['gg'],
        ['gg-circle'],
        ['git'],
        ['git-square'],
        ['github'],
        ['github-alt'],
        ['github-square'],
        ['gittip'],
        ['google'],
        ['google-plus'],
        ['google-plus-square'],
        ['google-wallet'],
        ['gratipay'],
        ['hacker-news'],
        ['houzz'],
        ['html5'],
        ['instagram'],
        ['internet-explorer'],
        ['ioxhost'],
        ['joomla'],
        ['jsfiddle'],
        ['lastfm'],
        ['lastfm-square'],
        ['leanpub'],
        ['linkedin'],
        ['linkedin-square'],
        ['linux'],
        ['maxcdn'],
        ['meanpath'],
        ['medium'],
        ['odnoklassniki'],
        ['odnoklassniki-square'],
        ['opencart'],
        ['openid'],
        ['opera'],
        ['optin-monster'],
        ['pagelines'],
        ['paypal'],
        ['pied-piper'],
        ['pied-piper-alt'],
        ['pinterest'],
        ['pinterest-p'],
        ['pinterest-square'],
        ['qq'],
        ['ra'],
        ['rebel'],
        ['reddit'],
        ['reddit-square'],
        ['renren'],
        ['safari'],
        ['sellsy'],
        ['share-alt'],
        ['share-alt-square'],
        ['shirtsinbulk'],
        ['simplybuilt'],
        ['skyatlas'],
        ['skype'],
        ['slack'],
        ['slideshare'],
        ['soundcloud'],
        ['spotify'],
        ['stack-exchange'],
        ['stack-overflow'],
        ['steam'],
        ['steam-square'],
        ['stumbleupon'],
        ['stumbleupon-circle'],
        ['tencent-weibo'],
        ['trello'],
        ['tripadvisor'],
        ['tumblr'],
        ['tumblr-square'],
        ['twitch'],
        ['twitter'],
        ['twitter-square'],
        ['viacoin'],
        ['vimeo'],
        ['vimeo-square'],
        ['vine'],
        ['vk'],
        ['wechat'],
        ['weibo'],
        ['weixin'],
        ['whatsapp'],
        ['wikipedia-w'],
        ['windows'],
        ['wordpress'],
        ['xing'],
        ['xing-square'],
        ['y-combinator'],
        ['y-combinator-square'],
        ['yahoo'],
        ['yc'],
        ['yc-square'],
        ['yelp'],
        ['youtube'],
        ['youtube-play'],
        ['youtube-square']
    ];
    var medicalIcons = [
        ['ambulance'],
        ['h-square'],
        ['heart'],
        ['heart-o'],
        ['heartbeat'],
        ['hospital-o'],
        ['medkit'],
        ['plus-square'],
        ['stethoscope'],
        ['user-md'],
        ['wheelchair']
    ];

    function showDialog() {

        var win;

        var hideAccordion = 0;

        function groupHtml(iconGroup, iconTitle) {

            var gridHtml;

            if (hideAccordion === 0) {
                gridHtml = '<div class="mce-fontawesome-panel-accordion"><div class="mce-fontawesome-panel-title">' + iconTitle + '</div>';
                gridHtml += '<div class="mce-fontawesome-panel-table" style="height: auto;"><table role="presentation" cellspacing="0"><tbody>';
                hideAccordion = 1;
            }
            else {
                gridHtml = '<div class="mce-fontawesome-panel-accordion mce-fontawesome-panel-accordion-hide"><div class="mce-fontawesome-panel-title">' + iconTitle + '</div>';
                gridHtml += '<div class="mce-fontawesome-panel-table"><table role="presentation" cellspacing="0"><tbody>';
            }

            var width = 22;

            for (y = 0; y < (iconGroup.length / width); y++) {
                gridHtml += '<tr>';

                for (x = 0; x < width; x++) {
                    if (iconTitle === 'Spinner') {
                        gridHtml += '<td><span class="fa fa-spin fa-' + iconGroup[y * width + x] + '"></span></td>';
                    }
                    else {
                        gridHtml += '<td><span class="fa fa-' + iconGroup[y * width + x] + '"></span></td>'
                        console.log(iconGroup[y * width + x]);
                    }
                }

                gridHtml += '</tr>';
            }

            gridHtml += '</tbody></table></div></div>';

            return gridHtml;

        }

        var panelHtml = groupHtml(webApplicationIcons, translate('Web Application'))
            + groupHtml(handIcons, translate('Hand'))
            + groupHtml(fileTypeIcons, translate('File Type'))
            + groupHtml(spinnerIcons, translate('Spinner'))
            + groupHtml(formControlIcons, translate('Form Control'))
            + groupHtml(currencyIcons, translate('Currency'))
            + groupHtml(textEditorIcons, translate('Text Editor'))
            + groupHtml(directionalIcons, translate('Directional'))
            + groupHtml(videoPlayerIcons, translate('Video Player'))
            + groupHtml(brandIcons, translate('Brand'))
            + groupHtml(medicalIcons, translate('Medical'))
            + groupHtml(transportationIcons, translate('Transportation'))
            + groupHtml(genderIcons, translate('Gender'))
            + groupHtml(paymentIcons, translate('Payment'))
            + groupHtml(chartIcons, translate('Chart'));

        win = editor.windowManager.open({
            autoScroll: true,
            width: 670,
            height: 500,
            title: 'Icons',
            spacing: 20,
            padding: 10,
            classes: 'fontawesome-panel',
            items: [
                {
                    type: 'container',
                    html: panelHtml,
                    onclick: function (e) {
                        var target = e.target;
                        if (target.nodeName == 'SPAN') {
                            editor.execCommand('mceInsertContent', false, target.outerHTML);
                            win.close();
                        }
                    },

                }, {
                    type: 'label',
                    text: ' '
                }
            ],
            buttons: [{
                text: 'Close',
                onclick: function () {
                    win.close();
                }
            }]
        });

        // Accordion

        var accordionItems = [];

        var divs = document.getElementsByTagName('div');
        for (var i = 0; i < divs.length; i++) {
            if (divs[i].className == 'mce-fontawesome-panel-accordion' || divs[i].className == 'mce-fontawesome-panel-accordion mce-fontawesome-panel-accordion-hide') {
                accordionItems.push(divs[i]);
            }
        }

        // Assign onclick events to the accordion item headings
        for (i = 0; i < accordionItems.length; i++) {
            var accordionTitle = getFirstChildWithTagName(accordionItems[i], 'DIV');
            accordionTitle.onclick = toggleItem;
        }

        var firstDiv = accordionItems[0].getElementsByTagName('div')[1];
        var firstDivHeight = firstDiv.offsetHeight;
        firstDiv.style.height = firstDivHeight + 'px';

        function toggleItem() {
            var itemClass = this.parentNode.className;

            // Hide all items
            for (var i = 0; i < accordionItems.length; i++) {
                accordionItems[i].className = 'mce-fontawesome-panel-accordion mce-fontawesome-panel-accordion-hide';
                accordionItems[i].getElementsByTagName('div')[1].style.height = '0';
            }

            // Show this item if it was previously hidden
            if (itemClass == 'mce-fontawesome-panel-accordion mce-fontawesome-panel-accordion-hide') {
                var accordionItemContent = this;
                do accordionItemContent = accordionItemContent.nextSibling; while(accordionItemContent && accordionItemContent.nodeType !== 1);

                accordionItemContent.style.height = 'auto';
                var divHeight = accordionItemContent.offsetHeight;
                accordionItemContent.style.height = '';
                this.parentNode.className = 'mce-fontawesome-panel-accordion';
                window.setTimeout(function () {
                    accordionItemContent.style.height = divHeight + 'px';
                }, 50);
            }
        }

        function getFirstChildWithTagName( element, tagName) {
            for (var i = 0; i < element.childNodes.length; i++) {
                if (element.childNodes[i].nodeName == tagName) {
                    return element.childNodes[i];
                }
            }
        }
    }

    editor.on('init', function() {

        var csslink = editor.dom.create('link', {
            rel: 'stylesheet',
            href: url + '/css/styles.min.css'
        });
        document.getElementsByTagName('head')[0].appendChild(csslink);
    });

    editor.addButton('fontawesome', {
        icon: true,
        image: url + "/img/fa.png",
        tooltip: translate('Icons'),
        onclick: showDialog
    });

    editor.addMenuItem('fontawesome', {
        icon: true,
        image: url + "/img/fa.png",
        onclick: showDialog,
        context: 'insert'
    });
});