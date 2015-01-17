<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>表白墙</title>
        <link rel="stylesheet" type="text/css" href="{$css_url_prefix}/head.css" />
        <link rel="shortcut icon" href="{$image_url_prefix}/favicon.png" >
    </head>
    <body>
        {include 'header.tpl'}
        <div class="text">
            <button onclick="window.location.href='{$commit_url}'" class="button black"/>我也要写表白</button>
            <button {if $prep_page_disabled eq 0}onclick="window.location.href='{$prep_page_url}'{/if}" class="page {if $prep_page_disabled neq 0}disabled{/if}"/>上一页</button>
            <button class="page disabled" />第{$page}页</button>
            <button {if $next_page_disabled eq 0}onclick="window.location.href='{$next_page_url}'{/if}" class="page {if $next_page_disabled neq 0}disabled{/if}"/>下一页</button>
            <div class="box">
                <b>02^华:</b>
                <p>欢迎来到表白墙，在这里你所发送的消息通通是匿名的！ 如果有疑问，请发送邮件到<a href=mailto:tyan-bbq@outlook.com?subject=表白墙反馈>tyan-bbq@outlook.com</a>。有什么想写给Ta但是又不好意思直说的，这里可以满足你的要求！</p>
            </div>
            {foreach $confessions as $confession}
                <div class="box">
                    <a href="pid.php?id=$id">{$confession.nick_name}</a>:
                    <br />
                    <p>
                        {$confession.content}
                    </p>
                    <span id="ttime">{$confession.post_time_str}</span>
                    <span id="fid">{$confession.conf_id}楼</span>
                </div>
            {/foreach}
        </div>
    </body>
</html>
