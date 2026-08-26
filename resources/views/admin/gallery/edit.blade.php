@extends('layouts.admin')

@section('title', 'Edit Gallery Folder')
@section('page-title', 'Edit Gallery Folder')

@section('content')

<div class="container-fluid gallery-edit-page">

    <div class="gallery-page-container">

        <section class="gallery-page-header">

            <div class="gallery-header-content">

                <span class="gallery-header-icon">
                    <i class="bi bi-pencil-square"></i>
                </span>

                <div>
                    <span class="gallery-header-eyebrow">
                        Gallery Management
                    </span>

                    <h2>Edit Gallery Folder</h2>

                    <p>
                        Update the folder settings and photos for
                        <strong>{{ $gallery->title }}</strong>.
                    </p>
                </div>

            </div>

            <a
                href="{{ route('admin.gallery.index') }}"
                class="gallery-back-button">

                <i class="bi bi-arrow-left"></i>
                <span>Back to Gallery</span>

            </a>

        </section>
<form
            action="{{ route('admin.gallery.update', $gallery) }}"
            method="POST"
            enctype="multipart/form-data"
            novalidate>

            @method('PUT')

            @include('admin.gallery._form', ['uploadMode' => false])

        </form>

        <form
            action="{{ route('admin.gallery.images.store', $gallery) }}"
            method="POST"
            enctype="multipart/form-data"
            novalidate
            class="mt-4">

            @include('admin.gallery._form', ['uploadMode' => true])

        </form>

    </div>

</div>

<div class="modal fade" id="galleryDeleteConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:0;border-radius:18px;overflow:hidden;">
            <div class="modal-header" style="border-bottom:1px solid #e5edf5;">
                <div>
                    <div style="color:#184b8c;font-size:10px;font-weight:800;letter-spacing:.12em;text-transform:uppercase;">
                        Confirm Deletion
                    </div>
                    <h5 class="modal-title" id="galleryDeleteConfirmTitle" style="margin:4px 0 0;color:#0b2e59;font-weight:800;">
                        Delete selected photos?
                    </h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="galleryDeleteConfirmBody" style="color:#647187;">
                This action cannot be undone.
            </div>
            <div class="modal-footer" style="border-top:1px solid #e5edf5;">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn" id="galleryDeleteConfirmButton" style="background:#d84b4b;color:#fff;font-weight:700;">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .gallery-edit-page {
        --navy: #0b2e59;
        --blue: #184b8c;
        --gold: #f4b400;
        padding: 24px;
    }

    .gallery-page-container {
        width: min(100%, 1120px);
        margin: 0 auto;
    }

    .gallery-page-header {
        position: relative;
        min-height: 142px;
        margin-bottom: 20px;
        padding: 27px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        overflow: hidden;
        color: #fff;
        background:
            radial-gradient(
                circle at 88% 12%,
                rgba(244, 180, 0, .23),
                transparent 28%
            ),
            linear-gradient(125deg, var(--navy), var(--blue));
        border-radius: 22px;
        box-shadow: 0 16px 36px rgba(11, 46, 89, .15);
    }

    .gallery-page-header::after {
        content: "";
        position: absolute;
        right: 16%;
        bottom: -86px;
        width: 180px;
        height: 180px;
        border: 27px solid rgba(255, 255, 255, .05);
        border-radius: 50%;
    }

    .gallery-header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 17px;
    }

    .gallery-header-icon {
        width: 60px;
        height: 60px;
        flex: 0 0 60px;
        display: grid;
        place-items: center;
        color: var(--navy);
        background: var(--gold);
        border-radius: 17px;
        font-size: 24px;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .14);
    }

    .gallery-header-eyebrow {
        display: block;
        margin-bottom: 4px;
        color: #ffd96d;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .gallery-page-header h2 {
        margin: 0 0 5px;
        font-size: clamp(23px, 3vw, 30px);
        font-weight: 800;
    }

    .gallery-page-header p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 12px;
    }

    .gallery-page-header p strong {
        color: #fff;
    }

    .gallery-back-button {
        position: relative;
        z-index: 1;
        min-height: 44px;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #fff;
        background: rgba(255, 255, 255, .1);
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 11px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        backdrop-filter: blur(8px);
        transition: .2s ease;
    }

    .gallery-back-button:hover {
        color: var(--navy);
        background: #fff;
        border-color: #fff;
        transform: translateY(-1px);
    }

    .gallery-form-alert {
        margin-bottom: 18px;
        padding: 16px 18px;
        display: flex;
        align-items: flex-start;
        gap: 13px;
        color: #883535;
        background: #fff7f7;
        border: 1px solid #f1caca;
        border-left: 4px solid #d84b4b;
        border-radius: 14px;
    }

    .gallery-alert-icon {
        width: 37px;
        height: 37px;
        flex: 0 0 37px;
        display: grid;
        place-items: center;
        color: #cf4242;
        background: #fde4e4;
        border-radius: 10px;
    }

    .gallery-alert-content strong {
        display: block;
        margin-bottom: 2px;
        font-size: 13px;
    }

    .gallery-alert-content p {
        margin: 0;
        color: #a35b5b;
        font-size: 11px;
    }

    .gallery-alert-content ul {
        margin: 9px 0 0;
        padding-left: 18px;
        color: #9a4b4b;
        font-size: 11px;
    }

    @media (max-width: 767.98px) {
        .gallery-edit-page {
            padding: 16px 10px;
        }

        .gallery-page-header {
            padding: 23px 20px;
            align-items: flex-start;
            flex-direction: column;
            border-radius: 18px;
        }

        .gallery-header-icon {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
            font-size: 21px;
        }

        .gallery-back-button {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const gallery = document.querySelector('.gallery-folder-form');
    const photoItems = Array.from(document.querySelectorAll('[data-gallery-photo-item]'));
    const selectionTrigger = document.querySelector('[data-gallery-select-trigger]');
    const selectionToolbar = document.querySelector('[data-gallery-selection-toolbar]');
    const selectionCount = document.querySelector('[data-gallery-selection-count]');
    const cancelSelectionButton = document.querySelector('[data-gallery-selection-cancel]');
    const selectAllButton = document.querySelector('[data-gallery-select-all]');
    const deleteSelectedButton = document.querySelector('[data-gallery-delete-selected]');
    const deleteModalElement = document.getElementById('galleryDeleteConfirmModal');
    const deleteModalTitle = document.getElementById('galleryDeleteConfirmTitle');
    const deleteModalBody = document.getElementById('galleryDeleteConfirmBody');
    const deleteModalButton = document.getElementById('galleryDeleteConfirmButton');
    const deleteFormsTarget = document.body;

    if (!gallery || !photoItems.length || typeof bootstrap === 'undefined') {
        return;
    }

    const deleteModal = deleteModalElement
        ? bootstrap.Modal.getOrCreateInstance(deleteModalElement)
        : null;

    const state = {
        active: false,
        selectedIds: new Set(),
        lastIndex: null,
        pendingDeleteIds: [],
        pendingDeleteLabel: 'photos',
        pointer: {
            timer: null,
            item: null,
            startX: 0,
            startY: 0,
            pointerId: null,
            moved: false,
            suppressClick: false
        }
    };

    function getPhotoId(item) {
        return String(item.dataset.photoId || '');
    }

    function getPhotoLabel(item) {
        return item.dataset.photoLabel || 'this photo';
    }

    function updateToolbar() {
        photoItems.forEach(function (item) {
            item.classList.toggle('is-selectable', state.active);
        });

        if (selectionTrigger) {
            selectionTrigger.classList.toggle('d-none', state.active);
        }

        if (selectionToolbar) {
            selectionToolbar.classList.toggle('d-none', !state.active);
        }

        if (selectionCount) {
            selectionCount.textContent = `${state.selectedIds.size} Selected`;
        }

        if (deleteSelectedButton) {
            deleteSelectedButton.disabled = state.selectedIds.size === 0;
        }

        if (selectAllButton) {
            const allSelected = state.selectedIds.size === photoItems.length && photoItems.length > 0;
            selectAllButton.querySelector('span').textContent = allSelected ? 'Deselect All' : 'Select All';
        }
    }

    function setSelected(item, selected) {
        const id = getPhotoId(item);
        if (!id) {
            return;
        }

        if (selected) {
            state.selectedIds.add(id);
            item.classList.add('is-selected');
        } else {
            state.selectedIds.delete(id);
            item.classList.remove('is-selected');
        }
    }

    function clearSelection(keepMode = false) {
        state.selectedIds.clear();
        photoItems.forEach(function (item) {
            item.classList.remove('is-selected');
        });
        state.lastIndex = null;
        if (!keepMode) {
            state.active = false;
        }
        updateToolbar();
    }

    function enterSelectionMode(selectItem = null) {
        state.active = true;
        if (selectItem) {
            setSelected(selectItem, true);
            state.lastIndex = photoItems.indexOf(selectItem);
        }
        updateToolbar();
    }

    function toggleSelection(item, index, forceState = null) {
        if (!item) {
            return;
        }

        const id = getPhotoId(item);
        const isSelected = state.selectedIds.has(id);
        const nextState = forceState === null ? !isSelected : forceState;

        setSelected(item, nextState);
        state.lastIndex = index;
        updateToolbar();
    }

    function selectRange(startIndex, endIndex) {
        const [from, to] = startIndex < endIndex
            ? [startIndex, endIndex]
            : [endIndex, startIndex];

        for (let i = from; i <= to; i++) {
            setSelected(photoItems[i], true);
        }
        state.lastIndex = endIndex;
        updateToolbar();
    }

    function selectAllDisplayed() {
        const allSelected = state.selectedIds.size === photoItems.length && photoItems.length > 0;

        if (allSelected) {
            clearSelection(true);
            updateToolbar();
            return;
        }

        photoItems.forEach(function (item, index) {
            setSelected(item, true);
            state.lastIndex = index;
        });

        state.active = true;
        updateToolbar();
    }

    function openDeleteConfirmation(ids, label) {
        if (!ids.length) {
            return;
        }

        state.pendingDeleteIds = ids.map(function (id) {
            return String(id);
        });
        state.pendingDeleteLabel = label || 'selected photos';

        if (deleteModalTitle) {
            deleteModalTitle.textContent = ids.length === 1
                ? 'Delete this photo?'
                : `Delete ${ids.length} photos?`;
        }

        if (deleteModalBody) {
            deleteModalBody.textContent = 'This action cannot be undone.';
        }

        deleteModal?.show();
    }

    function submitDelete(ids) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = @json(route('admin.gallery.images.bulk-destroy', $gallery));
        form.style.display = 'none';

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken || '';
        form.appendChild(csrfInput);

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        ids.forEach(function (id) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            form.appendChild(input);
        });

        deleteFormsTarget.appendChild(form);
        form.submit();
    }

    photoItems.forEach(function (item, index) {
        item.addEventListener('click', function (event) {
        if (!state.active && !event.ctrlKey && !event.metaKey && !event.shiftKey) {
            if (state.pointer.suppressClick) {
                state.pointer.suppressClick = false;
                return;
            }

            return;
        }

        if (state.pointer.suppressClick) {
            state.pointer.suppressClick = false;
            event.preventDefault();
            event.stopPropagation();
            return;
        }

        event.preventDefault();
        event.stopPropagation();

            if (!state.active) {
                enterSelectionMode(item);
                return;
            }

            if (event.shiftKey && state.lastIndex !== null) {
                selectRange(state.lastIndex, index);
                return;
            }

            if (event.ctrlKey || event.metaKey) {
                toggleSelection(item, index);
                return;
            }

            toggleSelection(item, index);
        });

        item.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                if (!state.active) {
                    enterSelectionMode(item);
                } else {
                    toggleSelection(item, index);
                }
            }
        });

        item.addEventListener('pointerdown', function (event) {
            if (event.pointerType !== 'touch') {
                return;
            }

            state.pointer.timer = window.setTimeout(function () {
                state.pointer.suppressClick = true;
                enterSelectionMode(item);
                toggleSelection(item, index, true);
            }, 500);

            state.pointer.item = item;
            state.pointer.startX = event.clientX;
            state.pointer.startY = event.clientY;
            state.pointer.pointerId = event.pointerId;
            state.pointer.moved = false;
            state.pointer.suppressClick = false;
        });

        item.addEventListener('pointermove', function (event) {
            if (state.pointer.pointerId !== event.pointerId || state.pointer.timer === null) {
                return;
            }

            const deltaX = Math.abs(event.clientX - state.pointer.startX);
            const deltaY = Math.abs(event.clientY - state.pointer.startY);

            if (deltaX > 8 || deltaY > 8) {
                state.pointer.moved = true;
                window.clearTimeout(state.pointer.timer);
                state.pointer.timer = null;
            }
        });

        const clearLongPress = function (event) {
            if (state.pointer.pointerId !== event.pointerId) {
                return;
            }

            window.clearTimeout(state.pointer.timer);
            state.pointer.timer = null;
            state.pointer.pointerId = null;
            state.pointer.item = null;
            state.pointer.moved = false;
        };

        item.addEventListener('pointerup', clearLongPress);
        item.addEventListener('pointercancel', clearLongPress);
        item.addEventListener('pointerleave', function (event) {
            if (event.pointerType === 'touch') {
                clearLongPress(event);
            }
        });

        const deleteButton = item.querySelector('.current-photo-delete');
        deleteButton?.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            const photoId = getPhotoId(item);
            openDeleteConfirmation([photoId], getPhotoLabel(item));
        });
    });

    selectionTrigger?.addEventListener('click', function () {
        enterSelectionMode();
    });

    cancelSelectionButton?.addEventListener('click', function () {
        clearSelection(false);
    });

    selectAllButton?.addEventListener('click', function () {
        selectAllDisplayed();
    });

    deleteSelectedButton?.addEventListener('click', function () {
        if (!state.selectedIds.size) {
            return;
        }

        openDeleteConfirmation(Array.from(state.selectedIds), 'selected photos');
    });

    deleteModalButton?.addEventListener('click', function () {
        if (!state.pendingDeleteIds.length) {
            return;
        }

        deleteModalButton.disabled = true;
        deleteModalButton.textContent = 'Deleting...';
        submitDelete(state.pendingDeleteIds);
    });

    deleteModalElement?.addEventListener('hidden.bs.modal', function () {
        deleteModalButton.disabled = false;
        deleteModalButton.textContent = 'Delete';
        state.pendingDeleteIds = [];
        state.pendingDeleteLabel = 'selected photos';
    });

    window.addEventListener('keydown', function (event) {
        if (!state.active) {
            return;
        }

        if (event.key === 'Escape') {
            clearSelection(false);
            return;
        }

        const targetTag = (event.target && event.target.tagName)
            ? event.target.tagName.toUpperCase()
            : '';

        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(targetTag) || event.target?.isContentEditable) {
            return;
        }

        if ((event.key === 'Delete' || event.key === 'Backspace') && state.selectedIds.size > 0) {
            event.preventDefault();
            openDeleteConfirmation(Array.from(state.selectedIds), 'selected photos');
        }
    });

    updateToolbar();
});
</script>
@endpush

