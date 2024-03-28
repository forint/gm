{if $company->id}
    {$meta_title = $company->name scope=global}
{else}
    {$meta_title = $btr->company_new_group scope=global}
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
                {if !$company->id}
                    {$btr->company_new_group|escape}
                {else}
                    {$company->name|escape}
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
                        {$btr->general_company_added|escape}
                        {elseif $message_success == 'updated'}
                        {$btr->general_company_updated|escape}
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
                            {$btr->company_general_name|escape}
                        </div>
                        <div class="form-group">
                            <input class="form-control mb-h" name="name" type="text" value="{$company->name|escape}"/>
                            <input name="id" type="hidden" value="{$company->id|escape}"/>
                        </div>
                        <div class="heading_label">
                            {$btr->company_general_email|escape}
                        </div>
                        <div class="form-group">
                            <input class="form-control mb-h" name="email" type="email" value="{$company->email|escape}"/>
                        </div>
                    </div>
                    {*Видимость элемента*}
                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <div class="activity_of_switch activity_of_switch--left mt-q mb-1">
                            <div class="activity_of_switch_item"> {* row block *}
                                <div class="okay_switch okay_switch--nowrap clearfix">
                                    <label class="switch_label">{$btr->general_enable|escape}</label>
                                    <label class="switch switch-default">
                                        <input class="switch-input" name="visible" value='1' type="checkbox" id="visible_checkbox" {if $company->visible}checked=""{/if}/>
                                        <span class="switch-label"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-4 col-md-6 col-sm-12 pr-0">
                        <div class="company_card">
                            <div class="company_card_header">
                                <span class="font-weight-bold">{$btr->general_countries|escape}</span>
                            </div>
                            <div class="company_card_block">
                                <select name="country" class="selectpicker form-control fn_action_select" data-selected-text-format="count">
                                    <option value="0" {if !$company->page_selected || 0|in_array:$company->page_selected}selected{/if}>{$btr->company_hide|escape}</option>
                                    {foreach from=$countries item=country}
                                        {if $country->name != ''}
                                            <option value="{$country->id}" {if $company->country && $country->id eq $company->country}selected{/if}>{$country->name|escape}</option>
                                        {/if}
                                    {/foreach}
                                </select>
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
</script>