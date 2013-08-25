{extends file="layout.tpl"}
{block name='body:id'}plugins-{$pluginName}{/block}
{block name="article:content"}
    <h1>Traduction statique</h1>
    <p>
        Les fichiers de traductions sont enregistrés avec l'extension .conf suivant la langue.
    </p>
    <p>
        Le dossier locali18 contient les fichiers de traductions pour l’ensemble des modules intégré,
        mais les plugins utilisent leur propre fichier de traduction.
    </p>
    <div class="row">
    {foreach $array_lang as $key => $value nocache}
    <div class="col-sm-3">
        <div class="well">
            <h2><span class="icon-flag"></span> {$value|upper}</h2>
            <p>
                <a class="btn btn-primary" href="/{baseadmin}/plugins.php?name=translation&amp;getlang={$key}&amp;action=list">
                    <span class="icon-folder-open"></span> Administrer
                </a>
            </p>
        </div>
    </div>
    {/foreach}
{/block}
{block name="modal"}
    <div id="window-dialog"></div>
{/block}
{block name='javascript'}
    {include file="js.tpl"}
{/block}