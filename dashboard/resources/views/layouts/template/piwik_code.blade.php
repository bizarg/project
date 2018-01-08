
JavaScript Tracking-код
<p>Удостоверьтесь, что этот код находится на каждой странице вашего вебсайта. Мы рекомендуем вставлять его сразу перед закрытием тега &lt;/head&gt;.</p>
<code >
    <div class="bg-piwik" style="background: #4d4d4d;color: #e2e7ea;border-radius: 5px;padding: 15px;">

        <span id="copy-code">
        &lt;!-- Piwik --&gt;;<br/>
                            &lt;script type="text/javascript"&gt; <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;var _paq = _paq || []; <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;/* tracker methods like "setCustomDimension" should be called before "trackPageView"*/ <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;_paq.push(['trackPageView']); <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;_paq.push(['enableLinkTracking']); <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;(function () { <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;var u="//piwik.staff.pub-dns.org/"; <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_paq.push(['setTrackerUrl', u+'piwik.php']); <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;_paq.push(['setSiteId', '{{ $domain }}']); <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; <br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);<br/>
                            &nbsp;&nbsp;&nbsp;&nbsp;})(); <br/>
                            &lt;/script&gt; <br/>
        &lt;!-- End Piwik Code --&gt;<br/>
        </span>
    </div>
</code>
{{--<button class="btn btn-default copy-button" data-clipboard-target="#copy-code">Copy</button>--}}
<p class="waves-effect waves-light right orangebtn btn">
    <input type="submit" class="copy-button" data-clipboard-target="#copy-code" value="Copy">
</p>

