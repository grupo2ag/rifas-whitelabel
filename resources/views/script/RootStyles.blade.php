<style>

    :root {
        --primary: {{$page['props']['siteconfig']['primary_color']}};
        --primary-bw: {{luminosity($page['props']['siteconfig']['primary_color'])}}
    }

{{--    {{dd($page['props']['siteconfig']['primary_color'])}}--}}

    [theme=light]{
        --root: 97.02% 0 0;
        --content:  100% 0 0;
        --base-100: 91.97% 0.004 286.32;
        --base-200: 87.11% 0.005 286.29;
        --base-300: 71.18% 0.013 286.07;
        --neutral: 14.08% 0.004 285.82;
        --neutral-bw: 14.08% 0.004 285.82;
        --success: 64.8% .15 160;
        --success-bw: 100% 0 0;
        --warning: 0.8471 0.199 83.87;
        --warning-bw: 0% 0 0;
        --info: 0.7206 0.191 231.6;
        --info-bw: 100% 0 0;
    }

    [theme=dark]{
        --root: 25.3267% .015896 252.417568;
        --content: 31.3815% .021108 254.139175;
        --base-100: 25.3267% .015896 252.417568;
        --base-200: 23.2607% .013807 253.100675;
        --base-300: 21.1484% .01165 254.087939;
        --neutral: 91.97% 0.004 286.32;
        --neutral-bw: 91.97% 0.004 286.32;
        --success: 64.8% .15 160;
        --success-bw: 100% 0 0;;
        --warning: 0.8471 0.199 83.87;
        --warning-bw: #000000;
        --info: 0.7206 0.191 231.6;
        --info-bw: 100% 0 0;
    }
</style>
