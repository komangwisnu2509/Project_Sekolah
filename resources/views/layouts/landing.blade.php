<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekolah Astika Dharma</title>
    <meta name="description" content="Sekolah Astika Dharma - Membentuk generasi unggul, berkarakter, dan kompeten untuk masa depan.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        :root {
            /* Colors */
            --primary: #0F172A; /* Dark Navy */
            --primary-light: #1E293B;
            --accent: #2563EB; /* Royal Blue */
            --accent-hover: #1D4ED8;
            --bg-light: #F8FAFC; /* Light gray background */
            --white: #FFFFFF;
            --text-main: #334155;
            --text-muted: #64748B;
            --border: #E2E8F0;
            
            /* Typography */
            --font-heading: 'Manrope', sans-serif;
            --font-body: 'Inter', sans-serif;
            
            /* Layout & Spacing */
            --radius-lg: 24px;
            --radius-md: 16px;
            --radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --section-padding: 6rem 5%;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            color: var(--text-main);
            background-color: var(--bg-light);
            line-height: 1.6;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-heading);
            color: var(--primary);
            line-height: 1.2;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }

        img {
            max-width: 100%;
            display: block;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }
        
        .section-subtitle {
            font-size: 1.125rem;
            color: var(--text-muted);
            margin-bottom: 3rem;
            max-width: 600px;
        }

        .text-center { text-align: center; }
        .mx-auto { margin-left: auto; margin-right: auto; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            font-family: var(--font-body);
        }

        .btn-primary {
            background-color: var(--accent);
            color: var(--white);
            box-shadow: 0 4px 14px 0 rgba(37, 99, 235, 0.39);
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.23);
        }

        .btn-outline {
            background-color: transparent;
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }
        
        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.25rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: var(--transition);
        }

        .navbar.transparent {
            background: transparent;
            color: var(--white);
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            color: var(--primary);
            padding: 0.85rem 5%;
        }

        .navbar.transparent .brand-title {
            color: #ffffff !important;
        }

        .navbar.scrolled .brand-title,
        .navbar:not(.transparent) .brand-title {
            color: #0f172a !important;
        }

        .navbar.transparent .brand-subtitle {
            color: #fbbf24 !important;
        }

        .navbar.scrolled .brand-subtitle,
        .navbar:not(.transparent) .brand-subtitle {
            color: #d97706 !important;
        }

        .navbar.transparent .mobile-nav-toggle {
            color: #ffffff !important;
        }

        .navbar.scrolled .mobile-nav-toggle,
        .navbar:not(.transparent) .mobile-nav-toggle {
            color: #0f172a !important;
        }

        .navbar.scrolled .nav-link,
        .navbar:not(.transparent) .nav-link {
            color: #1e293b !important;
        }

        .navbar.scrolled .btn-outline,
        .navbar:not(.transparent) .btn-outline {
            color: #2563eb !important;
            border-color: #2563eb !important;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-family: var(--font-heading);
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 0;
        }

        .navbar.scrolled .nav-link:hover {
            color: var(--accent);
        }
        
        .navbar.transparent .nav-link:hover {
            opacity: 0.8;
        }

        /* Dropdown (Simple CSS) */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            background: var(--white);
            min-width: 200px;
            border-radius: var(--radius-md);
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            padding: 0.5rem;
            display: flex;
            flex-direction: column;
        }

        .nav-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            color: var(--text-main);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: var(--bg-light);
            color: var(--accent);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Hero */
        .hero {
            position: relative;
            height: 100vh;
            min-height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--white);
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -2;
            transform: scale(1.05); /* Slight scale for potential animation */
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(15,23,42,0.6) 0%, rgba(15,23,42,0.8) 100%);
            z-index: -1;
        }

        .hero-content {
            max-width: 800px;
            padding: 0 1.5rem;
            z-index: 1;
            animation: fadeInUp 1s ease-out;
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            color: var(--white);
            margin-bottom: 1.5rem;
            line-height: 1.1;
            letter-spacing: -0.03em;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            color: rgba(255,255,255,0.85);
            font-weight: 400;
        }

        .hero-btns {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        /* Stats */
        .stats {
            background: var(--white);
            padding: 4rem 5%;
            margin-top: -50px;
            position: relative;
            z-index: 10;
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 40px rgba(0,0,0,0.05);
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
            position: relative;
        }

        .stat-item h3 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 0.25rem;
        }

        .stat-item p {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .stat-divider {
            position: absolute;
            width: 1px;
            height: 60%;
            background: var(--border);
            top: 20%;
        }
        
        .stat-divider:nth-child(2) { left: 25%; }
        .stat-divider:nth-child(4) { left: 50%; }
        .stat-divider:nth-child(6) { left: 75%; }

        /* About */
        .about { padding: var(--section-padding); }
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-image {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .about-image img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .about-image:hover img {
            transform: scale(1.05);
        }

        .about-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(37, 99, 235, 0.1);
            color: var(--accent);
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .about-text h2 { margin-bottom: 1.5rem; }
        .about-text p {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            color: var(--text-muted);
        }

        .link-arrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--accent);
            font-weight: 600;
            font-size: 1rem;
        }
        
        .link-arrow:hover { gap: 0.75rem; }

        /* Programs */
        .programs {
            background-color: var(--white);
            padding: var(--section-padding);
        }
        
        .programs-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .program-card {
            background: var(--bg-light);
            border-radius: var(--radius-lg);
            padding: 2.5rem;
            transition: var(--transition);
            border: 1px solid var(--border);
            text-align: left;
        }

        .program-card:hover {
            background: var(--white);
            box-shadow: 0 20px 40px rgba(0,0,0,0.06);
            transform: translateY(-5px);
            border-color: transparent;
        }

        .program-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: var(--white);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .program-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .program-card p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        /* Facilities - Editorial Layout */
        .facilities { padding: var(--section-padding); }
        .fac-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 1.5rem;
            height: 600px;
        }

        .fac-item {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            group: hover;
        }

        .fac-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s;
        }

        .fac-item:hover img { transform: scale(1.05); }

        .fac-item.large {
            grid-row: span 2;
        }

        .fac-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.8) 0%, transparent 60%);
            display: flex;
            align-items: flex-end;
            padding: 2rem;
        }

        .fac-content {
            color: var(--white);
        }

        .fac-content h3 {
            color: var(--white);
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        /* Extracurriculars - Horizontal Scroll */
        .eksul {
            background: var(--white);
            padding: var(--section-padding);
            overflow: hidden;
        }
        
        .eksul-wrapper {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding-bottom: 2rem;
            scrollbar-width: none; /* Firefox */
        }
        .eksul-wrapper::-webkit-scrollbar { display: none; }

        .eksul-card {
            min-width: 250px;
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            flex-shrink: 0;
        }

        .eksul-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        
        .eksul-card .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.9) 0%, transparent 50%);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }
        
        .eksul-card h3 { color: var(--white); font-size: 1.25rem; margin:0;}

        /* Achievements / Prestasi */
        .prestasi { padding: var(--section-padding); }
        .prestasi-box {
            background: #ffffff;
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .prestasi-box:hover {
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.12);
            border-color: rgba(99, 102, 241, 0.25);
        }

        .prestasi-img-card {
            position: relative;
            height: 300px;
            width: 100%;
            border-radius: 18px;
            overflow: hidden;
            background: #0f172a;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .prestasi-img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .prestasi-box:hover .prestasi-img-card img {
            transform: scale(1.05);
        }
        .prestasi-img-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.2) 0%, rgba(15, 23, 42, 0) 40%, rgba(15, 23, 42, 0.4) 100%);
            pointer-events: none;
        }

        .prestasi-content-inner {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0.5rem 0;
        }

        .prestasi-content-inner h2 { 
            font-size: 1.85rem; 
            font-weight: 800; 
            color: #0f172a; 
            letter-spacing: -0.02em; 
            line-height: 1.25; 
            margin-bottom: 0.75rem; 
        }

        .hover-elevate {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-elevate:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(79, 70, 229, 0.25) !important;
        }

        /* News / Portal */
        .news { padding: var(--section-padding); background: var(--white); }
        .news-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .news-main {
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
            height: 100%;
            min-height: 400px;
        }
        
        .news-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
        }
        
        .news-main-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15,23,42,0.9) 0%, transparent 60%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2.5rem;
            color: var(--white);
        }
        
        .news-main-overlay h3 { color: var(--white); font-size: 1.75rem; margin: 0.5rem 0 1rem; }
        .news-date { font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.8; }

        .news-list { display: flex; flex-direction: column; gap: 1.5rem; }
        .news-card {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            background: var(--bg-light);
            padding: 1rem;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }
        .news-card:hover { background: var(--white); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .news-card img {
            width: 120px;
            height: 120px;
            border-radius: var(--radius-sm);
            object-fit: cover;
        }
        .news-card-content h4 { font-size: 1.125rem; margin: 0.5rem 0; }

        /* Gallery - Masonry (CSS Columns) */
        .gallery { padding: var(--section-padding); }
        .gallery-grid {
            column-count: 3;
            column-gap: 1.5rem;
        }
        .gallery-item {
            break-inside: avoid;
            margin-bottom: 1.5rem;
            border-radius: var(--radius-md);
            overflow: hidden;
        }
        .gallery-item img {
            width: 100%;
            display: block;
            border-radius: var(--radius-md);
            transition: var(--transition);
        }
        .gallery-item:hover img { transform: scale(1.05); }

        /* Testimonials */
        .testimonials {
            background: var(--white);
            padding: var(--section-padding);
            text-align: center;
        }
        
        .testi-slider {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
        }

        .testi-content {
            font-size: 1.75rem;
            font-family: var(--font-heading);
            font-weight: 500;
            color: var(--primary);
            line-height: 1.4;
            margin-bottom: 2rem;
            font-style: italic;
        }

        .testi-author {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .testi-author h4 { font-size: 1.125rem; margin-bottom: 0.25rem; }
        .testi-author p { color: var(--text-muted); font-size: 0.875rem; }

        .testi-dots {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 3rem;
        }
        
        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--border);
            cursor: pointer;
            transition: var(--transition);
        }
        .dot.active { background: var(--accent); width: 20px; border-radius: 10px; }

        /* FAQ */
        .faq { padding: var(--section-padding); max-width: 800px; margin: 0 auto; }
        .faq-item {
            background: var(--white);
            border-radius: var(--radius-md);
            margin-bottom: 1rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        
        .faq-summary {
            padding: 1.5rem;
            font-weight: 600;
            font-family: var(--font-heading);
            font-size: 1.125rem;
            color: var(--primary);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            list-style: none;
        }
        
        .faq-summary::-webkit-details-marker { display: none; }
        
        .faq-content {
            padding: 0 1.5rem 1.5rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .faq-icon {
            transition: transform 0.3s ease;
        }

        details[open] .faq-icon {
            transform: rotate(45deg);
            color: var(--accent);
        }

        /* CTA */
        .cta { padding: var(--section-padding); }
        .cta-box {
            background: var(--primary);
            border-radius: var(--radius-lg);
            padding: 5rem 2rem;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
        }
        
        .cta-box h2 { color: var(--white); font-size: 3rem; margin-bottom: 1rem; position: relative; z-index: 2; }
        .cta-box p { font-size: 1.25rem; color: rgba(255,255,255,0.8); margin-bottom: 2.5rem; position: relative; z-index: 2;}
        
        .cta-decoration {
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(37, 99, 235, 0.2);
            filter: blur(80px);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            z-index: 1;
        }

        /* Footer */
        footer {
            background: var(--primary-light);
            color: var(--white);
            padding: 6rem 5% 2rem;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 4rem;
            margin-bottom: 4rem;
        }

        .footer-brand h3 {
            color: var(--white);
            font-size: 1.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .footer-brand p { color: rgba(255,255,255,0.7); max-width: 300px; }

        .footer-col h4 {
            color: var(--white);
            font-size: 1.125rem;
            margin-bottom: 1.5rem;
        }

        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 0.75rem; }
        .footer-col ul a { color: rgba(255,255,255,0.7); }
        .footer-col ul a:hover { color: var(--white); }

        .footer-contact li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            color: rgba(255,255,255,0.7);
            margin-bottom: 1rem;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            display: flex;
            justify-content: space-between;
            color: rgba(255,255,255,0.5);
            font-size: 0.875rem;
        }
        
        .social-links { display: flex; gap: 1rem; }
        .social-links a { color: rgba(255,255,255,0.5); }
        .social-links a:hover { color: var(--white); }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Mobile & Tablet Ultra-Polished Media Queries (Android, iOS & Tablet) */
        @media (max-width: 991.98px) {
            :root {
                --section-padding: 3.5rem 1.25rem;
            }

            /* Navbar Mobile Styling */
            .navbar {
                padding: 0.85rem 1.25rem;
            }
            .nav-brand {
                font-size: 1.05rem;
                max-width: 240px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .nav-links {
                display: none;
                position: fixed;
                top: 65px;
                left: 0;
                right: 0;
                width: 100vw;
                background: #0f172a !important;
                padding: 1.25rem 1rem 2rem !important;
                box-shadow: 0 20px 40px rgba(0,0,0,0.7);
                z-index: 1050;
                max-height: calc(100vh - 65px);
                overflow-y: auto;
                border-bottom: 3px solid #2563eb;
            }

            .nav-links.active {
                display: block !important;
                animation: fadeInUp 0.25s ease-out;
            }

            .nav-links .nav-item {
                width: 100% !important;
                margin-bottom: 0.65rem !important;
            }

            .nav-links .nav-link {
                color: #ffffff !important;
                font-size: 1.05rem !important;
                font-weight: 700 !important;
                padding: 0.75rem 1rem !important;
                background: rgba(255, 255, 255, 0.08) !important;
                border-radius: 10px !important;
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                border: 1px solid rgba(255, 255, 255, 0.12) !important;
            }

            .nav-links .nav-link:hover,
            .nav-links .nav-link:focus {
                background: rgba(37, 99, 235, 0.25) !important;
                color: #ffffff !important;
            }

            /* Sub-Menu Items inside Mobile Drawer - 100% Bright White & Visible */
            .nav-links .dropdown-menu {
                position: static !important;
                transform: none !important;
                float: none !important;
                display: block !important;
                opacity: 1 !important;
                visibility: visible !important;
                background: rgba(255, 255, 255, 0.04) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                box-shadow: none !important;
                margin: 0.4rem 0 0.5rem 0.5rem !important;
                padding: 0.5rem !important;
                border-radius: 10px !important;
            }

            .nav-links .dropdown-item {
                color: #ffffff !important;
                background: transparent !important;
                padding: 0.6rem 0.85rem !important;
                font-size: 0.92rem !important;
                font-weight: 600 !important;
                border-radius: 8px !important;
                display: block !important;
                white-space: normal !important;
                transition: all 0.2s ease !important;
                border-bottom: 1px dashed rgba(255, 255, 255, 0.08) !important;
            }
            .nav-links .dropdown-item:last-child {
                border-bottom: none !important;
            }

            .nav-links .dropdown-item:hover,
            .nav-links .dropdown-item:focus,
            .nav-links .dropdown-item:active {
                color: #ffffff !important;
                background: #2563eb !important;
                padding-left: 1.1rem !important;
            }

            .mobile-action-group {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
                margin-top: 1.25rem;
                padding-top: 1rem;
                border-top: 1px solid rgba(255,255,255,0.15);
            }

            /* Hero Section Mobile */
            .hero {
                min-height: 82vh;
                padding: 110px 1.25rem 50px;
            }
            .hero h1 {
                font-size: clamp(1.8rem, 5.5vw, 2.8rem) !important;
                line-height: 1.2 !important;
                margin-bottom: 1rem !important;
            }
            .hero p {
                font-size: 1rem !important;
                line-height: 1.6 !important;
                margin-bottom: 1.75rem !important;
            }
            .hero-btns {
                flex-direction: column;
                width: 100%;
                max-width: 320px;
                margin: 0 auto;
                gap: 0.75rem;
            }
            .hero-btns .btn {
                width: 100%;
                padding: 0.85rem 1.5rem;
                text-align: center;
                font-size: 0.95rem;
            }

            /* Stats Mobile */
            .stats {
                margin-top: -35px;
                padding: 1.5rem 1rem;
                border-radius: 18px;
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem 0.75rem;
            }
            .stat-divider { display: none; }
            .stat-item h3 { font-size: 1.8rem; }
            .stat-item p { font-size: 0.8rem; }

            /* Grids Mobile */
            .about-grid { grid-template-columns: 1fr; gap: 2rem; }
            
            /* Mobile Touch Horizontal Slider for Program Keahlian & Fasilitas */
            .programs-grid {
                display: flex !important;
                gap: 1.25rem !important;
                overflow-x: auto !important;
                padding-bottom: 1.5rem !important;
                padding-left: 0.25rem !important;
                padding-right: 0.25rem !important;
                scroll-snap-type: x mandatory !important;
                -webkit-overflow-scrolling: touch !important;
                scrollbar-width: none !important;
                margin-top: 0.5rem !important;
            }
            .programs-grid::-webkit-scrollbar { display: none !important; }
            
            .program-card {
                flex: 0 0 84% !important;
                max-width: 320px !important;
                min-width: 260px !important;
                scroll-snap-align: center !important;
                margin-bottom: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                border-radius: 20px !important;
                background: #ffffff !important;
                border: 1px solid rgba(226, 232, 240, 0.8) !important;
            }

            .fac-grid {
                display: flex !important;
                flex-direction: row !important;
                gap: 1.25rem !important;
                overflow-x: auto !important;
                padding-bottom: 1.5rem !important;
                padding-left: 0.25rem !important;
                padding-right: 0.25rem !important;
                scroll-snap-type: x mandatory !important;
                -webkit-overflow-scrolling: touch !important;
                scrollbar-width: none !important;
                height: auto !important;
                margin-top: 0.5rem !important;
            }
            .fac-grid::-webkit-scrollbar { display: none !important; }

            .fac-item {
                flex: 0 0 84% !important;
                max-width: 320px !important;
                min-width: 260px !important;
                height: 270px !important;
                scroll-snap-align: center !important;
                border-radius: 20px !important;
            }
            .fac-item.large {
                height: 270px !important;
            }
            
            .prestasi-box { flex-direction: column; border-radius: 18px; }
            .prestasi-img-card { height: 220px; }
            .prestasi-content { padding: 1.5rem 1.25rem; }

            .news-grid { grid-template-columns: 1fr; gap: 1.5rem; }
            .gallery-grid { column-count: 2; column-gap: 1rem; }
            
            .footer-grid { grid-template-columns: 1fr; gap: 2rem; }
            .footer-bottom { flex-direction: column; gap: 1rem; text-align: center; }
            .cta-box { padding: 3rem 1.25rem; border-radius: 20px; }
            .cta-box h2 { font-size: 1.75rem; }
        }

        @media (max-width: 576px) {
            .brand-emblem-badge { width: 36px !important; height: 36px !important; border-radius: 10px !important; }
            .brand-emblem-badge i { font-size: 1.15rem !important; }
            .brand-title { font-size: 0.88rem !important; }
            .brand-subtitle { font-size: 0.62rem !important; letter-spacing: 1px !important; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem 0.5rem; }
            .gallery-grid { column-count: 1; }
            .testi-content { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    @php
        $profilGlobal = $profil ?? \App\Models\ProfilSekolah::first();
    @endphp

    <!-- Navbar -->
    <nav class="navbar transparent" id="navbar">
        @php
            $rawName = $profilGlobal?->nama_sekolah ?? 'Utama Widyalaya Astika Dharma';
            if (str_contains($rawName, 'Utama Widyalaya')) {
                $mainBrand = 'Utama Widyalaya';
                $subBrand = str_replace('Utama Widyalaya', '', $rawName);
                $subBrand = trim($subBrand) ?: 'Astika Dharma';
            } else {
                $words = explode(' ', $rawName);
                if (count($words) > 1) {
                    $mainBrand = implode(' ', array_slice($words, 0, count($words)-1));
                    $subBrand = end($words);
                } else {
                    $mainBrand = $rawName;
                    $subBrand = 'Astika Dharma';
                }
            }
        @endphp
        <a href="{{ route('landing_page') }}" class="nav-brand text-decoration-none d-flex align-items-center me-2">
            <div class="brand-emblem-badge shadow-sm d-flex align-items-center justify-content-center me-2.5 position-relative" style="width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); border: 1.5px solid rgba(255, 255, 255, 0.3); flex-shrink: 0; transition: transform 0.3s ease;">
                <i class="bi bi-mortarboard-fill text-white fs-4"></i>
            </div>
            <div class="brand-text d-flex flex-column text-start" style="line-height: 1.15;">
                <span class="brand-title fw-extrabold text-uppercase" style="font-size: 1.05rem; font-weight: 800; letter-spacing: 0.5px; font-family: var(--font-heading);">
                    {{ strtoupper($mainBrand) }}
                </span>
                <span class="brand-subtitle fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 1.4px;">
                    {{ strtoupper($subBrand) }}
                </span>
            </div>
        </a>

        <!-- Mobile Hamburger Button -->
        <button class="mobile-nav-toggle border-0 bg-transparent fs-1 p-1 d-lg-none shadow-none ms-auto" type="button" id="btnMobileNavToggle" aria-label="Toggle Navigation">
            <i class="bi bi-list"></i>
        </button>
        
        <ul class="nav-links">
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#beranda" class="nav-link">Beranda</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#profil" class="nav-link">Profil <i data-lucide="chevron-down" size="16"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('tentang_sekolah') }}" class="dropdown-item">Mengenal Lebih Dekat</a>
                    <a href="{{ route('sambutan') }}" class="dropdown-item">Sambutan Kepala Sekolah</a>
                    <a href="{{ route('sejarah') }}" class="dropdown-item">Sejarah</a>
                    <a href="{{ route('visi_misi') }}" class="dropdown-item">Visi & Misi</a>
                    <a href="{{ route('guru_staff') }}" class="dropdown-item">Guru & Staff</a>
                    <a href="{{ route('fasilitas_sekolah') }}" class="dropdown-item">Fasilitas Sekolah</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#akademik" class="nav-link">Akademik <i data-lucide="chevron-down" size="16"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('landing_page') }}#program" class="dropdown-item">Program Keahlian</a>
                    <a href="{{ route('kurikulum') }}" class="dropdown-item">Kurikulum</a>
                    <a href="{{ route('ekstrakurikuler_sekolah') }}" class="dropdown-item">Ekstrakurikuler</a>
                    <a href="{{ route('landing_page') }}#prestasi" class="dropdown-item">Prestasi</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#informasi" class="nav-link">Informasi <i data-lucide="chevron-down" size="16"></i></a>
                <div class="dropdown-menu">
                    <a href="{{ route('berita') }}" class="dropdown-item">Berita & Kabar Sekolah</a>
                    <a href="{{ route('pengumuman') }}" class="dropdown-item">Pengumuman</a>
                    <a href="{{ route('agenda') }}" class="dropdown-item">Agenda</a>
                    <a href="{{ route('landing_page') }}#galeri" class="dropdown-item">Galeri</a>
                    <a href="{{ route('landing_page') }}#asdhatv" class="dropdown-item text-danger fw-bold"><i class="bi bi-youtube me-1"></i> ASDHA TV Media</a>
                </div>
            </li>
            <li class="nav-item">
                <a href="{{ route('landing_page') }}#kontak" class="nav-link">Kontak</a>
            </li>

            <!-- Mobile Drawer Action Buttons -->
            <li class="mobile-action-group d-lg-none">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill w-100 py-2.5 fw-bold">Masuk Dashboard</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('landing-logout-form').submit();" class="btn btn-outline-danger rounded-pill w-100 py-2">
                        <i data-lucide="log-out" size="16"></i> Log Out
                    </a>
                @else
                    <a href="{{ route('ppdb.index') }}" class="btn btn-primary rounded-pill w-100 py-2.5 fw-bold shadow">Daftar PPDB {{ date('Y') }}</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill w-100 py-2">Login ke Sistem</a>
                @endauth
            </li>
        </ul>

        <div class="nav-actions d-none d-lg-flex">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary" style="padding: 0.6rem 1.5rem; font-size: 0.875rem;">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" id="landing-logout-form" style="display: none;">
                    @csrf
                </form>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('landing-logout-form').submit();" class="btn btn-outline" style="padding: 0.6rem 1.2rem; font-size: 0.875rem; border-color: rgba(239, 68, 68, 0.6); color: #f87171;" title="Keluar dari Akun">
                    <i data-lucide="log-out" size="16"></i> Log Out
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline" style="padding: 0.6rem 1.5rem; font-size: 0.875rem;">Login</a>
                <a href="{{ route('ppdb.index') }}" class="btn btn-primary" style="padding: 0.6rem 1.5rem; font-size: 0.875rem;">PPDB {{ date('Y') }}</a>
            @endauth
        </div>
    </nav>

    <!-- Main Content -->
    <main style="min-height: 80vh;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="kontak">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3><i data-lucide="graduation-cap" size="24"></i> {{ $profilGlobal?->nama_sekolah ?? 'Sekolah Astika Dharma' }}</h3>
                    <p>{{ $profilGlobal?->slogan ?: 'Sekolah yang membangun generasi unggul, berkarakter, dan berdaya saing tinggi dalam teknologi dan keahlian vokasional.' }}</p>
                </div>
                
                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <ul>
                        <li><a href="{{ route('landing_page') }}#beranda">Beranda</a></li>
                        <li><a href="{{ route('landing_page') }}#profil">Profil Sekolah</a></li>
                        <li><a href="{{ route('landing_page') }}#akademik">Akademik</a></li>
                        <li><a href="{{ route('ppdb.index') }}">PPDB Online {{ date('Y') }}</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="{{ route('landing_page') }}#berita">Berita Terbaru</a></li>
                        <li><a href="{{ route('landing_page') }}#agenda">Agenda Sekolah</a></li>
                        <li><a href="{{ route('landing_page') }}#galeri">Galeri Foto</a></li>
                        <li><a href="{{ route('landing_page') }}#fasilitas">Fasilitas</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Kontak Resmi Sekolah</h4>
                    <ul class="footer-contact">
                        <li>
                            <i data-lucide="map-pin" size="18" style="flex-shrink: 0; margin-top: 3px;"></i>
                            <span>{{ $profilGlobal?->alamat ?: 'Jl. Pendidikan No. 45, Kompleks Edukasi Terpadu' }}</span>
                        </li>
                        <li>
                            <i data-lucide="phone" size="18" style="flex-shrink: 0;"></i>
                            <span>{{ $profilGlobal?->telepon ?: '081234567890' }}</span>
                        </li>
                        <li>
                            <i data-lucide="mail" size="18" style="flex-shrink: 0;"></i>
                            <span>{{ $profilGlobal?->email ?: 'info@astikadharma.sch.id' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div>&copy; {{ date('Y') }} {{ $profilGlobal?->nama_sekolah ?? 'Sekolah Astika Dharma' }}. All rights reserved.</div>
                <div class="social-links d-flex align-items-center gap-3">
                    @php
                        $waNumFooter = preg_replace('/[^0-9]/', '', $profilGlobal?->whatsapp ?? $profilGlobal?->telepon ?? '081234567890');
                        if (str_starts_with($waNumFooter, '0')) {
                            $waNumFooter = '62' . substr($waNumFooter, 1);
                        }
                    @endphp
                    <a href="https://wa.me/{{ $waNumFooter }}" target="_blank" title="WhatsApp Resmi" class="text-white opacity-85 hover-opacity-100 fs-5"><i class="bi bi-whatsapp text-success"></i></a>
                    @if($profilGlobal?->instagram)
                        @php
                            $igLink = str_starts_with($profilGlobal->instagram, 'http') ? $profilGlobal->instagram : 'https://instagram.com/' . ltrim($profilGlobal->instagram, '@');
                        @endphp
                        <a href="{{ $igLink }}" target="_blank" title="Instagram Resmi" class="text-white opacity-85 hover-opacity-100 fs-5"><i class="bi bi-instagram text-danger"></i></a>
                    @endif
                    @if($profilGlobal?->tiktok)
                        @php
                            $ttLink = str_starts_with($profilGlobal->tiktok, 'http') ? $profilGlobal->tiktok : 'https://tiktok.com/@' . ltrim($profilGlobal->tiktok, '@');
                        @endphp
                        <a href="{{ $ttLink }}" target="_blank" title="TikTok Official" class="text-white opacity-85 hover-opacity-100 fs-5"><i class="bi bi-tiktok text-white"></i></a>
                    @endif
                    @if($profilGlobal?->youtube)
                        <a href="{{ $profilGlobal->youtube }}" target="_blank" title="YouTube ASDHA TV" class="text-white opacity-85 hover-opacity-100 fs-5"><i class="bi bi-youtube text-danger"></i></a>
                    @endif
                    @if($profilGlobal?->facebook)
                        <a href="{{ $profilGlobal->facebook }}" target="_blank" title="Facebook Resmi" class="text-white opacity-85 hover-opacity-100 fs-5"><i class="bi bi-facebook text-primary"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize Lucide Icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Sticky Navbar Scroll Handler & Subpage Auto-Scrolled Mode
            const navbar = document.getElementById('navbar');
            const hasHero = document.querySelector('.hero');
            
            function handleNavbarStyle() {
                if (!navbar) return;
                if (!hasHero || window.scrollY > 30) {
                    navbar.classList.add('scrolled');
                    navbar.classList.remove('transparent');
                } else {
                    navbar.classList.remove('scrolled');
                    navbar.classList.add('transparent');
                }
            }
            
            handleNavbarStyle();
            window.addEventListener('scroll', handleNavbarStyle);

            // Mobile Navigation Toggle Handler for Android & iOS Touch Devices
            const btnMobileNavToggle = document.getElementById('btnMobileNavToggle');
            const navLinksElem = document.querySelector('.nav-links');
            if (btnMobileNavToggle && navLinksElem) {
                btnMobileNavToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    navLinksElem.classList.toggle('active');
                    const icon = btnMobileNavToggle.querySelector('i');
                    if (icon) {
                        icon.className = navLinksElem.classList.contains('active') ? 'bi bi-x-lg' : 'bi bi-list';
                    }
                });

                // Close mobile menu when clicking outside or clicking any nav link
                document.addEventListener('click', function(e) {
                    if (!navLinksElem.contains(e.target) && !btnMobileNavToggle.contains(e.target)) {
                        navLinksElem.classList.remove('active');
                        const icon = btnMobileNavToggle.querySelector('i');
                        if (icon) icon.className = 'bi bi-list';
                    }
                });

                navLinksElem.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        navLinksElem.classList.remove('active');
                        const icon = btnMobileNavToggle.querySelector('i');
                        if (icon) icon.className = 'bi bi-list';
                    });
                });
            }
        });
    </script>
    
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS Animation JS Init
        AOS.init({
            once: true,
            offset: 100,
            duration: 600,
            easing: 'ease-out-cubic',
        });

        // Number Counter Animation
        const counters = document.querySelectorAll('.counter');
        const speed = 100; // The higher the slower

        const startCounting = (counter) => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        };

        // Intersection Observer for Counters
        const statsSection = document.getElementById('stats-section');
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if(entry.isIntersecting){
                    counters.forEach(counter => {
                        startCounting(counter);
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        if(statsSection){
            observer.observe(statsSection);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
