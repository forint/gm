{if $country->id}
    {$meta_title = $country->name scope=global}
{else}
    {$meta_title = $btr->country_new_group scope=global}
{/if}

<style>
    @media (min-width: 1200px) and (max-width: 1400px) {
        .col-xxl-6{
            width: 100%;
        }
    }
</style>

{*Название страницы*}
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="wrap_heading">
            <div class="box_heading heading_page">
                {if !$country->id}
                    {$btr->country_new_group|escape}
                {else}
                    {$country->name|escape}
                {/if}
            </div>
        </div>
    </div>
</div>

{*Вывод успешных сообщений*}
{if $message_success}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="alert alert--center alert--icon alert--success">
                <div class="alert__content">
                    <div class="alert__title">
                        {if $message_success == 'added'}
                        {$btr->general_country_added|escape}
                        {elseif $message_success == 'updated'}
                        {$btr->general_country_updated|escape}
                        {/if}
                    </div>
                </div>
                {if $smarty.get.return}
                <a class="alert__button" href="{$smarty.get.return}">
                    {include file='svg_icon.tpl' svgId='return'}
                    <span>{$btr->general_back|escape}</span>
                </a>
                {/if}
            </div>
        </div>
    </div>
{/if}

{*Вывод ошибок*}
{if $message_error}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="alert alert--center alert--icon alert--error">
                <div class="alert__content">
                    <div class="alert__title">
                        {$message_error|escape}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}

{*Главная форма страницы*}
<form method="post" enctype="multipart/form-data" class="fn_fast_button">
    <input type=hidden name="session_id" value="{$smarty.session.id}">
    <input type="hidden" name="lang_id" value="{$lang_id}" />
    <div class="row">
        <div class="col-xs-12">
            <div class="boxed">
                <div class="row d_flex">
                    {*Название элемента сайта*}
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="heading_label">
                            {$btr->country_general_name|escape}
                        </div>
                        <div class="form-group">
                            <input class="form-control mb-h" name="name" type="text" value="{$country->name|escape}"/>
                            <input name="id" type="hidden" value="{$country->id|escape}"/>
                        </div>
                        <div class="heading_label">
                            {$btr->country_general_plan|escape}
                        </div>
                        <div class="form-group">
                            <input class="form-control mb-h" name="plan" type="text" value="{$country->plan|escape}"/>
                        </div>
                        <div class="heading_label">
                            {$btr->country_general_code|escape}
                        </div>
                        <div class="form-group">
                            <input class="form-control mb-h" name="code" type="text" value="{$country->code|escape}"/>
                        </div>
                    </div>
                    {*Видимость элемента*}
                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <div class="activity_of_switch activity_of_switch--left mt-q mb-1">
                            <div class="activity_of_switch_item"> {* row block *}
                                <div class="okay_switch okay_switch--nowrap clearfix">
                                    <label class="switch_label">{$btr->general_enable|escape}</label>
                                    <label class="switch switch-default">
                                        <input class="switch-input" name="visible" value='1' type="checkbox" id="visible_checkbox" {if $country->visible}checked=""{/if}/>
                                        <span class="switch-label"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 ">
                        <button type="submit" class="btn btn_small btn_blue float-md-right">
                            {include file='svg_icon.tpl' svgId='checked'}
                            <span>{$btr->general_apply|escape}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    sclipboard();

    $(document).on('change', '#select_all_categories', function () {
        $('.fn_select_all_categories option').prop("selected", $(this).is(':checked'));
        $('.fn_select_all_categories').selectpicker('refresh');
    });

    $(document).on('change', '#select_all_brands', function () {
        $('.fn_select_all_brands option').prop("selected", $(this).is(':checked'));
        $('.fn_select_all_brands').selectpicker('refresh');
    });

</script>