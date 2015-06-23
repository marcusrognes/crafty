<article id="post_{{ID}} columns">
    <div class="row">
        <div class="columns medium-6">
            {{#image}}
                <a href="{{guid}}">
                    <img src="{{medium}}" />
                </a>
            {{/image}}
        </div>
        <div class="columns medium-6">
            <header>
                <h1 class="page-title">
                    <a href="{{guid}}">
                        {{post_title}}
                    </a>
                </h1>
                <h4>
                    Posted on: {{post_date}} | By: {{author.display_name}}
                </h4>
            </header>
            <main>
                {{{post_excerpt}}}
            </main>
        </div>
    </div>
</article>