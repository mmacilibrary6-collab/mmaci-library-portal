<style>
    .donated-books-page {
        --navy: #0b2e59;
        --blue: #184b8c;
        --gold: #f4b400;
        --ink: #21344d;
        --muted: #728096;
        --line: #e5eaf1;
        --surface: #ffffff;
        padding: 24px;
    }
    .programs-hero{position:relative;overflow:hidden;min-height:150px;margin-bottom:22px;padding:28px 30px;display:flex;align-items:center;justify-content:space-between;gap:24px;border-radius:22px;background:radial-gradient(circle at 90% 10%, rgba(244,180,0,.2), transparent 28%),linear-gradient(125deg,var(--navy),var(--blue));box-shadow:0 16px 36px rgba(11,46,89,.16);color:#fff}
    .programs-hero::after{content:"";position:absolute;right:12%;bottom:-70px;width:180px;height:180px;border:28px solid rgba(255,255,255,.05);border-radius:50%}
    .hero-copy{position:relative;z-index:1;display:flex;align-items:center;gap:18px}
    .hero-icon{width:62px;height:62px;flex:0 0 62px;display:grid;place-items:center;border-radius:18px;background:var(--gold);color:var(--navy);font-size:27px;box-shadow:0 12px 25px rgba(0,0,0,.14)}
    .hero-eyebrow{display:block;margin-bottom:4px;color:#ffd96d;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase}
    .programs-hero h2{margin:0 0 5px;font-size:clamp(24px,3vw,32px);font-weight:800}
    .programs-hero p{max-width:600px;margin:0;color:rgba(255,255,255,.72);font-size:13px}
    .btn-add-program{position:relative;z-index:1;min-height:46px;padding:0 18px;display:inline-flex;align-items:center;justify-content:center;gap:9px;border-radius:12px;background:var(--gold);color:var(--navy);font-size:13px;font-weight:800;text-decoration:none;box-shadow:0 10px 22px rgba(0,0,0,.15);transition:.2s ease}
    .btn-add-program:hover{color:var(--navy);background:#ffc62b;transform:translateY(-2px)}
    .programs-panel{overflow:hidden;border:1px solid var(--line);border-radius:20px;background:var(--surface);box-shadow:0 12px 30px rgba(25,50,80,.07)}
    .panel-toolbar{padding:20px 22px;display:flex;align-items:center;justify-content:space-between;gap:20px;border-bottom:1px solid var(--line)}
    .panel-toolbar h5{margin:0 0 3px;color:var(--navy);font-size:16px;font-weight:800}
    .panel-toolbar p{margin:0;color:var(--muted);font-size:11px}
    .program-search{width:min(100%,430px);display:flex;gap:8px}
    .search-field{position:relative;flex:1}
    .search-field>i{position:absolute;top:50%;left:14px;color:#93a0b2;transform:translateY(-50%)}
    .search-field input{width:100%;height:42px;padding:0 42px 0 40px;border:1px solid var(--line);border-radius:11px;outline:none;color:var(--ink);font-size:12px;transition:.2s ease}
    .search-field input:focus{border-color:var(--blue);box-shadow:0 0 0 3px rgba(24,75,140,.1)}
    .clear-search{position:absolute;top:50%;right:13px;color:#9aa6b5;font-size:11px;transform:translateY(-50%)}
    .program-search button{height:42px;padding:0 17px;border:0;border-radius:11px;background:var(--navy);color:#fff;font-size:12px;font-weight:700}
    .program-search button:hover{background:var(--blue)}
    .programs-table{min-width:850px}
    .programs-table thead th{padding:13px 18px;border:0;border-bottom:1px solid var(--line);background:#f8fafc;color:#7b8798;font-size:10px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;white-space:nowrap}
    .programs-table tbody td{padding:15px 18px;border-color:#edf0f4;color:var(--ink);font-size:12px;vertical-align:middle}
    .programs-table tbody tr:hover{background:#fbfcfe}
    .number-column,.row-number{width:58px;color:#98a4b4 !important;text-align:center}
    .program-identity{min-width:220px;display:flex;align-items:center;gap:12px}
    .program-thumbnail{width:46px;height:46px;flex:0 0 46px;overflow:hidden;display:grid;place-items:center;border-radius:12px;background:linear-gradient(145deg,#fff4ca,#ffe078);color:var(--navy);font-size:20px}
    .program-thumbnail img{width:100%;height:100%;object-fit:cover}
    .program-identity strong{display:block;margin-bottom:2px;color:var(--navy);font-size:13px;font-weight:750}
    .program-identity small{color:#98a4b4;font-size:10px}
    .description-cell{max-width:360px;color:var(--muted) !important;line-height:1.55}
    .status-badge{min-width:78px;padding:6px 10px;display:inline-flex;align-items:center;justify-content:center;gap:6px;border-radius:30px;font-size:10px;font-weight:800}
    .status-badge>span{width:6px;height:6px;border-radius:50%}
    .status-badge.active{background:#eaf8f0;color:#1b7548}
    .status-badge.active>span{background:#27a866}
    .status-badge.hidden{background:#f0f2f5;color:#687589}
    .status-badge.hidden>span{background:#8995a6}
    .table-actions{display:flex;justify-content:flex-end;gap:7px}
    .table-actions form{margin:0}
    .action-button{width:35px;height:35px;padding:0;display:inline-grid;place-items:center;border:1px solid transparent;border-radius:10px;font-size:13px;text-decoration:none;transition:.2s ease}
    .action-button.edit{border-color:#d8e4f2;background:#f2f7fc;color:var(--blue)}
    .action-button.delete{border-color:#f3d8d8;background:#fff5f5;color:#c53e3e}
    .action-button:hover{transform:translateY(-2px)}
    .action-button.edit:hover{background:var(--blue);color:#fff}
    .action-button.delete:hover{background:#d64a4a;color:#fff}
    .empty-state{padding:60px 20px;text-align:center}
    .empty-state>span{width:64px;height:64px;margin:0 auto 15px;display:grid;place-items:center;border-radius:18px;background:#edf3f9;color:var(--blue);font-size:27px}
    .empty-state h5{margin-bottom:5px;color:var(--navy);font-weight:800}
    .empty-state p{margin-bottom:14px;color:var(--muted);font-size:12px}
    .empty-state a{color:var(--blue);font-size:12px;font-weight:700;text-decoration:none}
    .panel-footer{padding:14px 20px;display:flex;align-items:center;justify-content:space-between;gap:20px;border-top:1px solid var(--line);background:#fbfcfd}
    .panel-footer p{margin:0;color:var(--muted);font-size:11px}
    .panel-footer .pagination{margin:0}
    .donated-book-form-page{--navy:#0b2e59;--blue:#184b8c;--gold:#f4b400;padding:24px}
    .create-page-container{width:min(100%,1120px);margin:0 auto}
    .create-header{position:relative;overflow:hidden;min-height:142px;margin-bottom:20px;padding:27px 30px;display:flex;align-items:center;justify-content:space-between;gap:24px;border-radius:22px;background:radial-gradient(circle at 88% 12%, rgba(244,180,0,.22), transparent 28%),linear-gradient(125deg,var(--navy),var(--blue));color:#fff;box-shadow:0 16px 36px rgba(11,46,89,.15)}
    .create-header::after{content:"";position:absolute;right:16%;bottom:-86px;width:180px;height:180px;border:27px solid rgba(255,255,255,.05);border-radius:50%}
    .header-content{position:relative;z-index:1;display:flex;align-items:center;gap:17px}
    .header-icon{width:60px;height:60px;flex:0 0 60px;display:grid;place-items:center;border-radius:17px;background:var(--gold);color:var(--navy);font-size:25px;box-shadow:0 12px 25px rgba(0,0,0,.14)}
    .header-eyebrow{display:block;margin-bottom:4px;color:#ffd96d;font-size:10px;font-weight:800;letter-spacing:.14em;text-transform:uppercase}
    .create-header h2{margin:0 0 5px;font-size:clamp(23px,3vw,30px);font-weight:800}
    .create-header p{margin:0;color:rgba(255,255,255,.72);font-size:12px}
    .create-header p strong{color:#fff;font-weight:700}
    .back-button{position:relative;z-index:1;min-height:44px;padding:0 16px;display:inline-flex;align-items:center;justify-content:center;gap:8px;border:1px solid rgba(255,255,255,.24);border-radius:11px;background:rgba(255,255,255,.1);color:#fff;font-size:12px;font-weight:700;text-decoration:none;backdrop-filter:blur(8px);transition:.2s ease}
    .back-button:hover{border-color:#fff;background:#fff;color:var(--navy);transform:translateY(-1px)}
    .program-form{--navy:#0b2e59;--blue:#184b8c;--gold:#f4b400;--text:#253851;--muted:#7c899b;--line:#e3e9f0}
    .program-form .form-section{margin-bottom:18px;padding:24px;border:1px solid var(--line);border-radius:18px;background:#fff;box-shadow:0 8px 24px rgba(11,46,89,.05)}
    .program-form .section-heading{margin-bottom:22px;padding-bottom:17px;display:flex;align-items:center;gap:12px;border-bottom:1px solid #edf1f5}
    .program-form .section-icon{width:42px;height:42px;flex:0 0 42px;display:grid;place-items:center;border-radius:12px;background:#eaf1f9;color:var(--blue);font-size:18px}
    .program-form .section-icon.image-icon{background:#fff5d7;color:#b98500}
    .program-form .section-heading h5{margin:0 0 3px;color:var(--navy);font-size:15px;font-weight:800}
    .program-form .section-heading p{margin:0;color:var(--muted);font-size:11px}
    .program-form .form-label{margin-bottom:10px;color:var(--text);font-size:13px;font-weight:700}
    .program-form .form-label span,.program-form .form-label small{color:var(--muted);font-size:11px;font-weight:500}
    .program-form .form-control,.program-form .form-select{min-height:44px;border-color:var(--line);border-radius:12px;color:var(--text);font-size:13px;box-shadow:none}
    .program-form .form-control:focus,.program-form .form-select:focus{border-color:rgba(24,75,140,.55);box-shadow:0 0 0 .2rem rgba(24,75,140,.08)}
    .program-form .image-fields{display:flex;flex-direction:column;gap:18px}
    .program-form .upload-area{min-height:182px;padding:24px;display:flex;align-items:center;justify-content:center;gap:16px;border:1px dashed #d5deea;border-radius:18px;background:linear-gradient(180deg,#fbfdff 0%, #f7faff 100%);cursor:pointer;transition:.2s ease}
    .program-form .upload-area:hover{border-color:rgba(24,75,140,.4);background:#f8fbff;transform:translateY(-1px)}
    .program-form .upload-icon{width:54px;height:54px;flex:0 0 54px;display:grid;place-items:center;border-radius:16px;background:#eaf1f9;color:var(--blue);font-size:22px}
    .program-form .upload-copy strong,.program-form .upload-copy small{display:block}
    .program-form .upload-copy strong{margin-bottom:4px;color:var(--navy);font-size:15px;font-weight:800}
    .program-form .upload-copy small{color:var(--muted);font-size:11px}
    .program-form .browse-button{margin-left:auto;padding:10px 16px;border-radius:999px;background:var(--gold);color:var(--navy);font-size:11px;font-weight:800}
    .program-form .preview-panel{height:100%;display:flex;flex-direction:column;gap:12px}
    .program-form .preview-label{display:flex;justify-content:space-between;gap:12px;align-items:center}
    .program-form .preview-label span{color:var(--navy);font-size:13px;font-weight:800}
    .program-form .preview-label small{color:var(--muted);font-size:11px}
    .program-form .program-image-preview{position:relative;overflow:hidden;min-height:280px;border-radius:18px;background:#edf3f9}
    .program-form .program-image-preview img{width:100%;height:100%;min-height:280px;object-fit:cover}
    .program-form .preview-overlay{position:absolute;right:14px;bottom:14px;padding:9px 14px;display:inline-flex;align-items:center;gap:8px;border-radius:999px;background:rgba(11,46,89,.9);color:#fff;font-size:11px;font-weight:700}
    .program-form .form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:18px}
    .program-form .btn-cancel,.program-form .btn-save{min-height:46px;padding:0 18px;display:inline-flex;align-items:center;justify-content:center;gap:8px;border-radius:999px;font-size:13px;font-weight:800;text-decoration:none}
    .program-form .btn-cancel{border:1px solid var(--line);background:#fff;color:var(--text)}
    .program-form .btn-save{border:0;background:var(--gold);color:var(--navy)}
    .program-form .btn-save:hover,.program-form .btn-cancel:hover{transform:translateY(-1px)}

    .folder-page {
        --navy: #0b2e59;
        --blue: #184b8c;
        --gold: #f4b400;
        --ink: #21344d;
        --muted: #728096;
        --line: #e5eaf1;
        --surface: #ffffff;
        padding: 24px;
    }

    .folder-page-header {
        position: relative;
        overflow: hidden;
        min-height: 150px;
        margin-bottom: 22px;
        padding: 28px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        border-radius: 22px;
        background: radial-gradient(circle at 90% 10%, rgba(244,180,0,.2), transparent 28%), linear-gradient(125deg, var(--navy), var(--blue));
        box-shadow: 0 16px 36px rgba(11,46,89,.16);
        color: #fff;
    }

    .folder-page-header::after {
        content: "";
        position: absolute;
        right: 12%;
        bottom: -70px;
        width: 180px;
        height: 180px;
        border: 28px solid rgba(255,255,255,.05);
        border-radius: 50%;
    }

    .folder-heading {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .folder-heading-icon {
        width: 62px;
        height: 62px;
        flex: 0 0 62px;
        display: grid;
        place-items: center;
        border-radius: 18px;
        background: var(--gold);
        color: var(--navy);
        font-size: 27px;
        box-shadow: 0 12px 25px rgba(0,0,0,.14);
    }

    .folder-heading span {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .folder-heading h2 {
        margin: 0 0 5px;
        font-size: clamp(24px,3vw,32px);
        font-weight: 800;
    }

    .folder-heading p {
        max-width: 600px;
        margin: 0;
        color: rgba(255,255,255,.72);
        font-size: 13px;
    }

    .add-folder-button {
        position: relative;
        z-index: 1;
        min-height: 46px;
        padding: 0 18px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        border-radius: 12px;
        background: var(--gold);
        color: var(--navy);
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 10px 22px rgba(0,0,0,.15);
        transition: .2s ease;
    }

    .add-folder-button:hover {
        color: var(--navy);
        background: #ffc62b;
        transform: translateY(-2px);
    }

    .folder-management-card {
        overflow: hidden;
        border: 1px solid #e7edf4;
        border-radius: 22px;
        background: var(--surface);
        box-shadow: 0 12px 30px rgba(25,50,80,.06);
    }

    .folder-filters {
        width: 100%;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        border-bottom: 1px solid var(--line);
    }

    .folder-search {
        position: relative;
        flex: 1 1 320px;
    }

    .folder-search > i {
        position: absolute;
        top: 50%;
        left: 14px;
        color: #93a0b2;
        transform: translateY(-50%);
    }

    .folder-search input {
        width: 100%;
        height: 42px;
        padding: 0 42px 0 40px;
        border: 1px solid var(--line);
        border-radius: 11px;
        outline: none;
        color: var(--ink);
        font-size: 12px;
        transition: .2s ease;
    }

    .folder-search input:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(24,75,140,.1);
    }

    .program-filter {
        width: min(100%, 320px);
        height: 42px;
        border: 1px solid var(--line);
        border-radius: 11px;
        color: var(--ink);
        font-size: 12px;
        box-shadow: none;
    }

    .filter-button {
        height: 42px;
        padding: 0 17px;
        border: 0;
        border-radius: 11px;
        background: var(--navy);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
    }

    .filter-button:hover {
        background: var(--blue);
        color: #fff;
    }

    .clear-filter-button {
        width: 42px;
        height: 42px;
        padding: 0;
        display: grid;
        place-items: center;
        border-radius: 11px;
        border: 1px solid var(--line);
        background: #fff;
        color: #93a0b2;
    }

    .folder-results-bar {
        padding: 14px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        border-bottom: 1px solid #e7edf4;
        background: #fbfcfd;
        color: var(--muted);
        font-size: 11px;
    }

    .folder-results-bar strong {
        color: var(--navy);
        font-size: 12px;
        font-weight: 800;
    }

    .folder-table {
        min-width: 1020px;
    }

    .folder-table thead th {
        padding: 14px 18px;
        border: 0;
        border-bottom: 1px solid #e7edf4;
        background: #f8fafc;
        color: #7b8798;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .folder-table tbody td {
        padding: 18px 18px;
        border-color: #edf0f4;
        color: var(--ink);
        font-size: 12px;
        vertical-align: middle;
    }

    .folder-table tbody tr:hover {
        background: #fbfcfe;
    }

    .accession-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 28px;
        padding: 0 11px;
        border: 1px solid #d8e2ef;
        border-radius: 8px;
        background: linear-gradient(180deg, #fff, #f6f9fd);
        color: var(--navy);
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .03em;
    }

    .folder-information {
        min-width: 220px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .folder-row-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        overflow: hidden;
        display: grid;
        place-items: center;
        border-radius: 12px;
        background: linear-gradient(145deg, #fff4ca, #ffe078);
        color: var(--navy);
        font-size: 20px;
    }

    .folder-copy strong {
        display: block;
        margin-bottom: 2px;
        color: var(--navy);
        font-size: 13px;
        font-weight: 750;
    }

    .folder-copy small {
        color: #98a4b4;
        font-size: 10px;
    }

    .program-name,
    .program-missing,
    .drive-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        max-width: 100%;
        font-size: 12px;
    }

    .program-name {
        padding: 8px 10px;
        border-radius: 10px;
        background: #eef5ff;
        color: var(--navy);
        font-weight: 700;
    }

    .program-missing {
        color: #8f9ab0;
        font-weight: 700;
    }

    .drive-link {
        color: var(--blue);
        font-weight: 700;
        text-decoration: none;
    }

    .drive-link:hover {
        color: var(--navy);
    }

    .folder-table tbody tr {
        transition: background-color .18s ease;
    }

    .folder-table tbody tr:hover {
        background: #fbfcfe;
    }

    .action-column {
        width: 130px;
    }

    @media (max-width: 991.98px) {
        .folder-page-header,
        .folder-filters {
            flex-direction: column;
            align-items: stretch;
        }

        .folder-heading {
            align-items: flex-start;
        }

        .folder-table {
            min-width: 860px;
        }
    }
</style>
