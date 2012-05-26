<h1 id="header">Principles</h1>

<div class="content">
    <h2>The increasing trend of mobile learning</h2>
    <p>Recent years have seen an ever increasing trend toward mobile learning. 
        By recent estimation, over half of all college students have 
        Internet-capable handheld devices. A dean in higher education even 
        remarked that &quot;students were more likely to remember their phone than 
        their wallet&quot;.</p>
    <p>This being the case, a mobile presence is no longer just a desire, but 
        rather an expectation.</p>

    <h2>Native apps versus web apps</h2>
    <p>Generally, two approaches exist for a mobile application:
        <ul>
            <li>Native - Platform-specific applications that run on specific device 
                hardware, generally with low portability, centralized distribution 
                and robust hardware interfaces.</li>
            <li>Web - Web applications that run in an Internet browser, consequently
                with superior portability but also an apparent lack of hardware 
                interfaces. Although the web is ideally portable across devices as 
                is, in reality browsers interface still vary enough to require 
                variation.</li>
        </ul>
    </p>
    <p>The mobile device platform market is rapidly and continually expanding. 
        As students are early and frequent adopters of new technologies such as 
        mobile devices, developing a native application that serves a 
        substantial number of devices on campus quickly becomes a challenge. 
        Therefore, the Mobile Web Framework instead focuses on providing a 
        web-based platform that can serve the vast majority of mobile devices.</p>

    <h2>An approach to the mobile web</h2>
    <p>As opposed to the traditional web, which is a collection of disparate 
        content linked by page hops and searches, the mobile web focuses on an 
        integrated experience categorized by task-oriented and directed content.
        It offers a single platform from which content can be delivered to all 
        web-capable devices, but it drives many developers away because of the 
        wide range of capabilities between different browsers. The Mobile Web 
        Framework removes this challenge in developing for the mobile web.</p>
    <p>By including the CSS and Javascript files provided by the framework, any 
        content provider can write one set of code that works on all devices to 
        the best of their capabilities. Further, by using browser-side 
        technologies (CSS and Javascript), the framework can be included by web 
        applications written in any programming language and running in any 
        server environment.</p>
    <p>Beyond these benefits, the nature of the framework as hosted centrally, 
        but leveraged in a distributed fashion, it allows a service provider to 
        establish a unified identity for the entire mobile application, 
        regardless of what server or environment the actual application resides 
        in. This allows content providers to leverage it from their own server 
        with their own business logic and data, while appearing as part of a 
        single environment, heterogeneous in composition but homogeneous in 
        appearance to the end user.</p>
    <p>The UCLA Mobile Web Framework is currently in production across numerous 
        institutions, including five in the University of California system with
        several more preparing to roll out applications using it.</p>

    <h2>Principles</h2>
    <p>The Mobile Web Framework has several guiding principles:
        <ul>
            <li><strong>Device Agnostic</strong> Works on any web-capable 
                device.</li>
            <li><strong>Graceful Degradation</strong> Provides functionality to 
                the best ability of each device.</li>
            <li><strong>Federated Architecture</strong> Run centrally, but used 
                in a distributed manner.</li>
            <li><strong>Unified Mobile Presence</strong> One outwards presence 
                even in a distributed environment.</li>
            <li><strong>Language & Environment</strong> Independent Compatible 
                with any language system and environment.</li>
            <li><strong>Modern Web Standards</strong> Complies with modern web 
                standards.</li>
        </ul>
    </p>
    
    <h2>Anatomy</h2>
    <p>A library of stylesheets, Javascript and other scripts make up the core 
        of the framework.</p>
    <p>By providing markup standards, CSS definitions, Javascript functions and 
        other scripts, the framework allows a developer to write a single set of
        markup that works on all devices that qualify under the framework's 
        minimum standard while still taking advantage of device specific 
        features when available.</p>
    <p>The framework, at this time, distinguishes between three different types 
        of phones:
        <ul>
            <li><strong>Full</strong> Styles elements with CSS 3 and exposes 
                HTML 5 functionality where available.</li>
            <li><strong>Standard</strong> CSS 2.1, HTML 4.01 and ECMA-262-3 
                (Javascript 1.5) support.</li>
            <li><strong>Basic</strong> Least common denominator with XHTML MP 
                1.0 and WCSS.</li>
        </ul>
    </p>
    <p>Based on telemetry determined from the visiting device, the framework 
        guides page presentation and interactive functionality. Advanced UI and 
        phone-specific features can be made available, all through HTML class 
        and id tags, and, in some cases, through basic Javascript. Therefore, in
        addition to styling, the framework allows an application developer a 
        standardized way to interface with phone-specific features such as HTML 
        5 technologies, gestures, geo-location, and more, all through 
        browser-side CSS and Javascript includes.</p>
    <p>In addition, for modules running on the same host as the framework, the 
        framework also includes a set of PHP object libraries both to access 
        framework telemetry and to build pages using decorators.</p>

    <h2>Implementation</h2>
    <p>The rapidly changing mobile device landscape presents one of the greatest
        challenges for the mobile developer. In the past, developers have had to
        address these differences individually. This has added enormous overhead
        to the development of mobile applications in terms of scope, resources, 
        and budget- both upfront in development and implementation, and later, 
        in maintenance and upgrade cycles. The UCLA Mobile web Framework allows 
        developers (including Universities) to avoid detailed device-by-device 
        planning, implementation, upgrades and maintenance and all their 
        associated costs, and instead makes real the promise of &quot;develop 
        once, use everywhere&quot; by providing a simple abstraction layer 
        whereby the framework itself makes device-by-device determinations.</p>
    <p>A central server hosts the front splash page, as well as the framework 
        core (CSS, Javascript, utilities, other assets, and the scripts that 
        serve them).</p>
    <img src="<?php echo URL::asset('images/components.png'); ?>">
    <p>The splash page acts as a portal for various mobile sites. These sites 
        may be hosted on the same central server, or they may be hosted 
        completely separately (such as by a different department). By leveraging
        the centrally-hosted framework, all these sites are tied together with a
        common look and feel, leading to the appearance of all these sites as a 
        single application. To achieve this, each application must reference the
        central framework CSS, Javascript and other utility assets, maintaining 
        a consistent UCLA mobile identity and providing the applications with an
        enhanced level of functionality.</p>
    <p>To implement the framework, a content provider primarily needs only to 
        implement HTML entity classes and include the CSS and Javascript 
        handlers; through CSS and Javascript, these classes deliver 
        functionality defined through the framework for each device 
        classification. Some classes define mobile-styled menus, buttons, and 
        content areas, while others enable interactive capabilities like 
        Javascript element toggling, touch screen gesture detection, and even 
        geolocation and address book functionality.</p>
    <p>The framework documentation also provides comprehensive information for 
        developing MWF applications, including specifications for both styling 
        and interface classes in the framework, as well as general HTML 
        recommendations necessary for semantic degradation on non-CSS 
        devices.</p>
</div>