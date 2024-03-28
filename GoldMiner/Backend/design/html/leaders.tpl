{* Title *}
{$meta_title=$btr->companies scope=global}
{*Название страницы*}
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="wrap_heading">
            <div class="box_heading heading_page">
                {$btr->leaders|escape}
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
                        {$btr->general_leaders_added|escape}
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
    <div class="boxed boxed_sorting fn_toggle_wrap">
        <div class="row">
            <div class="col-md-2 col-lg-2 col-sm-12">
                <button type="submit" name="generate_data" value="generate_data" class="btn btn_small btn_blue float-md-left">
                    {include file='svg_icon.tpl' svgId='checked'}
                    <span>{$btr->generate_data|escape}</span>
                </button>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-12">
                <div>
                    <select id="year" name="year" class="selectpicker form-control" title="{$btr->select_month|escape}" data-live-search="true">
                            <option value=''>--Select Year--</option>
                            {for $year=$year_from to $year_to}
                                <option value='{$year}' filter='{$year}' {if $filter.year == {$year}}selected{/if}>{$year}</option>
                            {/for}
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-12">
                <div>
                    <select id="month" name="month" class="selectpicker form-control" title="{$btr->select_month|escape}" data-live-search="true">
                            <option value=''>--Select Month--</option>
                            <option value='1' filter='1' {if $filter.month == 1}selected{/if}>January</option>
                            <option value='2' filter='2' {if $filter.month == 2}selected{/if}>February</option>
                            <option value='3' filter='3' {if $filter.month == 3}selected{/if}>March</option>
                            <option value='4' filter='4' {if $filter.month == 4}selected{/if}>April</option>
                            <option value='5' filter='5' {if $filter.month == 5}selected{/if}>May</option>
                            <option value='6' filter='6' {if $filter.month == 6}selected{/if}>June</option>
                            <option value='7' filter='7' {if $filter.month == 7}selected{/if}>July</option>
                            <option value='8' filter='8' {if $filter.month == 8}selected{/if}>August</option>
                            <option value='9' filter='9' {if $filter.month == 9}selected{/if}>September</option>
                            <option value='10' filter='10' {if $filter.month == 10}selected{/if}>October</option>
                            <option value='11' filter='11' {if $filter.month == 11}selected{/if}>November</option>
                            <option value='12' filter='12' {if $filter.month == 12}selected{/if}>December</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-12">
                <button type="submit" name="show_report" value="show_report" class="btn btn_small btn_blue float-md-left">
                    {include file='svg_icon.tpl' svgId='checked'}
                    <span>{$btr->show_report|escape}</span>
                </button>
            </div>
        </div>
    </div>
    <div class="boxed fn_toggle_wrap">
        <div class="row">
            {if $leaders}
                <div class="categories">
                    <form class="fn_form_list" method="post">
                        <input type="hidden" name="session_id" value="{$smarty.session.id}">
                        <div class="okay_list products_list fn_sort_list">
                            {*Шапка таблицы*}
                            <div class="okay_list_head">
                                <div class="okay_list_heading okay_list_features_name">{$btr->company_general_name|escape}</div>
                                <div class="okay_list_heading okay_list_brands_tag">{$btr->leaders_mined|escape}</div>
                                <div class="okay_list_heading okay_list_close"></div>
                            </div>
                            {*Параметры элемента*}
                            <div class="companies_wrap okay_list_body features_wrap sortable">
                            {foreach $leaders as $leader}
                                <div class="fn_row okay_list_body_item fn_sort_item">
                                    <div class="okay_list_row">
                                        <input type="hidden" name="positions[{$leader->id}]" value="{$leader->position|escape}">

                                        <div class="okay_list_boding okay_list_features_name">
                                            <span class="text_dark text_700 font_12">{$leader->name|escape}</span>
                                        </div>

                                        <div class="okay_list_boding okay_list_brands_tag">
                                            <span class="text_dark text_700 font_12">{$leader->mined|escape} T ( {$leader->plan} T)</span>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm 12 txt_center">
                        {include file='pagination.tpl'}
                    </div>
                </div>
            {else}
                <div class="heading_box mt-1">
                    <div class="text_grey">{$btr->no_companies|escape}</div>
                </div>
            {/if}
        </div>
    </div>
</form>
