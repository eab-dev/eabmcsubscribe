{* Display error messages *}
{if $errors}
<div class="warning">
    <h2>Please fix the following issues and try again</h2>
    <ul>
    {foreach $errors as $error}
        <li>{$error}</li>
    {/foreach}
    </ul>
</div>
{/if}
