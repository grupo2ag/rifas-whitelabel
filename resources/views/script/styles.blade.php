<style>
    :root {
        --primary: {{$page['props']['siteconfig']['primary_color']}};
        --primary-bw: {{luminosity($page['props']['siteconfig']['primary_color'])}}
    }

    [theme=light]{
        --root: 245 245 245;
        --content:  255 255 255;
        --base-100: 228 228 231;
        --base-200: 212 212 216;
        --base-300: 161, 161, 170;
        --neutral: 9 9 11;
        --neutral-bw: {{luminosity('9 9 11')}};
        --success: 0 169 111;
        --success-bw: {{luminosity('0 169 111')}};
        --warning: 255 194 45;
        --warning-bw: {{luminosity('255 194 45')}};
        --info: 0 179 240;
        --info-bw: {{luminosity('0 179 240')}};
        --error: 255 51 51;
        --error-bw: {{luminosity('255 51 51')}};
    }

    [theme=dark]{
        --root: 29 35 42;
        --content: 42 50 60;
        --base-100: 29 35 42;
        --base-200: 25 30 36;
        --base-300: 21 25 30;
        --neutral: 255 255 255;
        --neutral-bw: {{luminosity('255 255 255')}};
        --success: 0 169 111;
        --success-bw: {{luminosity('0 169 111')}};
        --warning: 255 194 45;
        --warning-bw: {{luminosity('255 194 45')}};
        --info: 0 179 240;
        --info-bw: {{luminosity('0 179 240')}};
        --error: 255 51 51;
        --error-bw: {{luminosity('255 51 51')}};
    }
</style>
