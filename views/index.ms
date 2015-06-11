<section>
    <div class="header">
        {{>header/mobile.nav}}
    </div>
    <div class="content">
        {{#posts}}
        {{>post/list}}
        {{/posts}}
    </div>
</section>