A minimalist [WordPress](https://www.wordpress.org) theme for your portfolio. Open-source, continuously supported, and free to use.

The theme is clean, content-focused, and designed for clarity. It offers simple, straight forward typography readable on a wide variety of screen sizes, and suitable for multiple languages. It is designed using a mobile-first approach, meaning your content takes center-stage, regardless of whether your visitors arrive by smartphone, tablet, laptop, or desktop computer.

![Portfolio Theme Screen Shot](https://raw.githubusercontent.com/aidanamavi/portfolio-theme/master/img/markdown_screenshot.jpg "Portfolio Theme Screen Shot")



## Why is this so awesome?

* :rocket: **Integration with world-class open-source software.** Tested with and built on Linux, Apache, MySQL, PHP, WordPress, jQuery, Matomo, and Wordfence.
* :zap: **Incredibly fast with built-in caching.** Front-end client-side caching with AJAX built-in.
* :lock: **Works seamlessly with encrypted content.** Works automagically with your SSL certificates.
* :+1: **Standards compliant & validated code.** HTML5, CSS3, and JSLint code analysis and verification.
* :iphone: **Responsive design.** Support for desktops, laptops, tablets, and smartphone screens.
* :bar_chart: **Matomo Analytics integration.** Works automagically without any setup.
* :mag: **Search Engine Optimized.** Organizes your content behind-the-scenes for optimal indexing.
* :page_facing_up: **Printer friendly.** Print your About page to use as your in person resume.
* :wheelchair: **Accessible friendly.** W3C Web Accessibility Initiative (WAI) support across all devices.
* :computer: **Flows like a modern web app.** Intelligent loading screens ensure your first impression is amazing.

And in the works for [the future](https://github.com/aidanamavi/portfolio-theme/milestones/):
* :rocket: **Further WP Integration** A post type for About content.
* :zap: **Speed Optimization** Backend compression, and caching options.
* :art: **UX/UI** Work navigation sub-menu: keywords, products, roles.
* :art: **UX/UI** Blog navigation sub-menu: archive, categories, rss.



## Requirements

* [PHP](https://www.php.net/) >= 7
* [WordPress](https://www.wordpress.org) >= 4.1



## Installation

First upload the theme to your WordPress themes directory.
1. Navigate to `Appearance > Themes > Add New > Upload Theme`
2. Upload the theme zip file.

To begin using the theme, we will activate it.
1. Navigate to `Appearance > Themes`
2. Click the 'Activate' button.

To setup our home page, we will create a page for it.
1. Navigate to `Pages > Add New`
2. Enter 'Homepage' as the title.
3. Select the `Page Attributes > Template` named Homepage
4. Click Publish to save the page.

To direct our visitors to our designated home page, we will forward traffic there.
1. Navigate to `Customize > Homepage Settings`
2. Select the radio button for "A static page".
3. Select the Homepage to use as your home page.

If you experience any issues or have enhancement suggestions, you can report them in the [issue tracker](https://github.com/aidanamavi/portfolio-theme/issues). If it's a challenging issue, it's suggested that you follow the [issue template](https://raw.githubusercontent.com/aidanamavi/portfolio-theme/master/issues-template.md), so all the necessary info to debug and fix the issue is available. Thanks!



## Setup

### Set up your About page.

1. Select 'Pages' and then 'Add New'
2. Set the page title to 'About'
3. Set the page template to 'About'
4. Click 'Publish'
5. Ensure your permalink points to yourdomain.com/about/
6. To edit your new page, manually edit the code in the index-about.php template file.

### Tips

1. 16:9 images work best for several reasons.
2. Avoid using external hosting services like YouTube.
3. Rename your homepage, give it a description, and perform other SEO optimizations.
4. If you struggle with these tips, ask for help through the [issue tracker](https://github.com/aidanamavi/portfolio-resume/issues).


## Recommended Plug-ins

* Wordfence Security
* Rank Math SEO



### Server-side caching
Front-end caching is done automagically. Back-end caching will be provided in a future release.



## Maintainers

Active: [Aidan Amavi](https://github.com/AidanAmavi)

If you’d like to help, just go through the [issue list](https://github.com/aidanamavi/portfolio-resume/issues) and fix some. :)
