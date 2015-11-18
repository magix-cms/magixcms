<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Organization",
  "name" : "{#website_name#}",
  "alternateName" : "Bijouterie David Mann",
  "url" : "{geturl}",
  "logo": "{geturl}/{getlang}/skin/{template}/img/{#logo_img#}",
  "contactPoint" : [{
    "@type" : "ContactPoint",
    "telephone" : "{#contact_phone#}",
    "contactType" : "customer support",
    "availableLanguage" : ["French"]
  }],
  "sameAs" : [
    "{#fb_url#}",
    "{#lk_url#}",
    "{#gg_url#}"
  ]{if isset($search) && $search && $search_query},
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{$search_query}{literal}{search_term_string}{/literal}",
    "query-input": "required name=search_term_string"
  }
  {/if}
}
</script>