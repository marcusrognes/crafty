{{>parts/header/topbar-left-flyout}}

{{#post}}
    <article id="post_{{ID}}">
        <header>
            {{#image}}
                <img src="{{banner-large}}" />
            {{/image}}
            {{^image}}
                <img src="http://lorempixel.com/1024/170/cats/" />
            {{/image}}
        </header>
        <main class="row">
            <div class="columns">
                <h1>
                    {{post_title}}
                </h1>
                <h4>
                    Posted on: {{post_date}} | By: {{author.display_name}}
                </h4>
                <hr>
                {{{post_content}}}
            </div>
        </main>
        <footer class="row">
            <hr>
            {{>parts/content/sharing}}
        </footer>
    </article>
{{/post}}

{{>parts/footer/basic}}