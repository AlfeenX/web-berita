@props([
    'name' => 'content', 
    'value' => '', 
    'placeholder' => 'Mulai menulis konten artikel...'
])

<div
    x-data="{
        content: @js($value),
        fieldName: '{{ $name }}',
        linkUrl: '',
        currentColor: '#888780',
        wordCount: 0,
        charCount: 0,
        savedRange: null,
        active: {
            bold: false,
            italic: false,
            underline: false,
            strikeThrough: false,
            insertUnorderedList: false,
            insertOrderedList: false,
            createLink: false
        },
        init() {
            this.$refs.editor.innerHTML = this.content;
            this.updateStats();
            
            // Listen for direct input modifications
            this.$refs.editor.addEventListener('input', () => this.onInput());
            this.$refs.editor.addEventListener('blur', () => this.onInput());
            
            this.$refs.editor.addEventListener('focus', () => {
                if (!this.$refs.editor.innerText.trim()) {
                    this.$refs.editor.innerHTML = '';
                }
            });
        },
        fmt(cmd) {
            this.$refs.editor.focus();
            document.execCommand(cmd, false, null);
            this.updateState();
            this.onInput();
        },
        applyHeading(tag) {
            this.$refs.editor.focus();
            document.execCommand('formatBlock', false, tag);
            this.updateState();
            this.onInput();
        },
        saveRange() {
            const sel = window.getSelection();
            this.savedRange = sel.rangeCount > 0 ? sel.getRangeAt(0).cloneRange() : null;
        },
        restoreRange() {
            if (!this.savedRange) return;
            const sel = window.getSelection();
            sel.removeAllRanges();
            sel.addRange(this.savedRange);
        },
        applyColor(color) {
            this.$refs.editor.focus();
            this.restoreRange();
            if (color === 'default') {
                document.execCommand('removeFormat', false, null);
            } else {
                document.execCommand('styleWithCSS', false, true);
                document.execCommand('foreColor', false, color);
                this.currentColor = color;
            }
            this.updateState();
            this.onInput();
        },
        applyLink() {
            const url = this.linkUrl.trim();
            if (!url) return;
            this.$refs.editor.focus();
            this.restoreRange();
            document.execCommand('createLink', false, url);
            this.$refs.editor.querySelectorAll('a').forEach(a => {
                a.setAttribute('target', '_blank');
                a.setAttribute('rel', 'noopener noreferrer');
            });
            this.linkUrl = '';
            this.updateState();
            this.onInput();
        },
        insertBlockquote() {
            this.$refs.editor.focus();
            document.execCommand('formatBlock', false, 'blockquote');
            this.onInput();
        },
        insertCode() {
            this.$refs.editor.focus();
            const sel = window.getSelection();
            const selected = sel ? sel.toString() : '';
            if (selected) {
                document.execCommand('insertHTML', false, `<code>${selected}</code>`);
            } else {
                document.execCommand('insertHTML', false, '<pre><code>// kode di sini</code></pre><p></p>');
            }
            this.onInput();
        },
        clearFormat() {
            this.$refs.editor.focus();
            document.execCommand('removeFormat', false, null);
            document.execCommand('formatBlock', false, 'p');
            this.updateState();
            this.onInput();
        },
        updateState() {
            ['bold','italic','underline','strikeThrough','insertUnorderedList','insertOrderedList','createLink'].forEach(cmd => {
                this.active[cmd] = document.queryCommandState(cmd);
            });
        },
        onInput() {
            this.content = this.$refs.editor.innerHTML;
            this.updateStats();
        },
        updateStats() {
            const text = this.$refs.editor.innerText.trim();
            this.wordCount = text ? text.split(/\s+/).filter(Boolean).length : 0;
            this.charCount = text.length;
        }
    }"
    class="overflow-hidden rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900"
>

    {{-- ── Toolbar ─────────────────────────────────────────────── --}}
    <div class="flex flex-wrap items-center gap-0.5 border-b border-zinc-200 bg-zinc-50 px-2 py-1.5 dark:border-zinc-700 dark:bg-zinc-800">

        {{-- Heading select --}}
        <select
            @change="applyHeading($event.target.value); $event.target.value = 'p'"
            class="h-7 cursor-pointer appearance-none rounded bg-transparent py-0 pl-1.5 pr-5 text-xs text-zinc-600 outline-none hover:bg-white focus:bg-white dark:text-zinc-400 dark:hover:bg-zinc-700 dark:focus:bg-zinc-700"
            style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%2210%22 height=%2210%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%23888%22 stroke-width=%222%22%3E%3Cpolyline points=%226 9 12 15 18 9%22%3E%3C/polyline%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 4px center;"
        >
            <option value="p">Paragraph</option>
            <option value="h1">Heading 1</option>
            <option value="h2">Heading 2</option>
            <option value="h3">Heading 3</option>
        </select>

        <div class="mx-1.5 h-5 w-px bg-zinc-200 dark:bg-zinc-600"></div>

        {{-- Bold / Italic / Underline / Strike --}}
        <button type="button" @click="fmt('bold')"
            :class="active.bold ? 'bg-white text-zinc-900 dark:bg-zinc-700 dark:text-zinc-100' : 'text-zinc-500 hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100'"
            class="flex h-7 w-7 items-center justify-center rounded text-sm font-bold transition"
            title="Bold">B</button>

        <button type="button" @click="fmt('italic')"
            :class="active.italic ? 'bg-white text-zinc-900 dark:bg-zinc-700 dark:text-zinc-100' : 'text-zinc-500 hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100'"
            class="flex h-7 w-7 items-center justify-center rounded text-sm italic font-semibold transition"
            title="Italic">I</button>

        <button type="button" @click="fmt('underline')"
            :class="active.underline ? 'bg-white text-zinc-900 dark:bg-zinc-700 dark:text-zinc-100' : 'text-zinc-500 hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100'"
            class="flex h-7 w-7 items-center justify-center rounded text-sm font-semibold underline transition"
            title="Underline">U</button>

        <button type="button" @click="fmt('strikeThrough')"
            :class="active.strikeThrough ? 'bg-white text-zinc-900 dark:bg-zinc-700 dark:text-zinc-100' : 'text-zinc-500 hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100'"
            class="flex h-7 w-7 items-center justify-center rounded text-sm font-semibold line-through transition"
            title="Strikethrough">S</button>

        <div class="mx-1.5 h-5 w-px bg-zinc-200 dark:bg-zinc-600"></div>

        {{-- Text color --}}
        <div class="relative" x-data="{ open: false }">
            <button
                type="button"
                @click="saveRange(); open = !open"
                class="relative flex h-7 w-7 items-center justify-center rounded text-zinc-500 transition hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100"
                title="Text color"
            >
                <svg width="14" height="14" viewBox="0 0 14 14" fill="currentColor" aria-hidden="true"><text x="1" y="12" font-size="13" font-family="serif" font-weight="700">A</text></svg>
                <span
                    class="absolute bottom-1 left-1/2 h-0.5 w-3.5 -translate-x-1/2 rounded-full transition"
                    :style="'background:' + currentColor"
                ></span>
            </button>

            <div
                x-show="open"
                @click.outside="open = false"
                x-cloak
                class="absolute left-0 top-full z-20 mt-1.5 flex w-36 flex-wrap gap-1 rounded-xl border border-zinc-200 bg-white p-2 dark:border-zinc-700 dark:bg-zinc-800"
            >
                @foreach ([
                    '#e24b4a', '#ef9f27', '#639922',
                    '#378add', '#7f77dd', '#1d9e75',
                    '#d85a30', '#888780', 'default',
                ] as $color)
                    @if ($color === 'default')
                        <button
                            type="button"
                            @click="applyColor('default'); open = false"
                            class="h-[18px] w-[18px] rounded-full border border-zinc-300 bg-white dark:border-zinc-600 dark:bg-zinc-900 hover:scale-110 transition"
                            title="Default color"
                        ></button>
                    @else
                        <button
                            type="button"
                            @click="applyColor('{{ $color }}'); open = false"
                            class="h-[18px] w-[18px] rounded-full hover:scale-110 transition"
                            :style="'background: ' + @js($color)"
                            title="{{ $color }}"
                        ></button>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="mx-1.5 h-5 w-px bg-zinc-200 dark:bg-zinc-600"></div>

        {{-- Lists --}}
        <button type="button" @click="fmt('insertUnorderedList')"
            :class="active.insertUnorderedList ? 'bg-white text-zinc-900 dark:bg-zinc-700 dark:text-zinc-100' : 'text-zinc-500 hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100'"
            class="flex h-7 w-7 items-center justify-center rounded transition"
            title="Bullet list"
            aria-label="Bullet list">
            <flux:icon name="list-bullet" class="h-4 w-4" />
        </button>

        <button type="button" @click="fmt('insertOrderedList')"
            :class="active.insertOrderedList ? 'bg-white text-zinc-900 dark:bg-zinc-700 dark:text-zinc-100' : 'text-zinc-500 hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100'"
            class="flex h-7 w-7 items-center justify-center rounded transition"
            title="Ordered list"
            aria-label="Ordered list">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="10" y1="6" x2="21" y2="6"/><line x1="10" y1="12" x2="21" y2="12"/><line x1="10" y1="18" x2="21" y2="18"/><text x="2" y="8" font-size="7" fill="currentColor" stroke="none" font-family="sans-serif">1</text><text x="2" y="14" font-size="7" fill="currentColor" stroke="none" font-family="sans-serif">2</text><text x="2" y="20" font-size="7" fill="currentColor" stroke="none" font-family="sans-serif">3</text></svg>
        </button>

        <div class="mx-1.5 h-5 w-px bg-zinc-200 dark:bg-zinc-600"></div>

        {{-- Blockquote & Code --}}
        <button type="button" @click="insertBlockquote()"
            class="flex h-7 w-7 items-center justify-center rounded text-zinc-500 transition hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100"
            title="Blockquote" aria-label="Blockquote">
            <flux:icon name="chat-bubble-left-right" class="h-4 w-4" />
        </button>

        <button type="button" @click="insertCode()"
            class="flex h-7 w-7 items-center justify-center rounded text-zinc-500 transition hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100"
            title="Code block" aria-label="Code block">
            <flux:icon name="code-bracket" class="h-4 w-4" />
        </button>

        <div class="mx-1.5 h-5 w-px bg-zinc-200 dark:bg-zinc-600"></div>

        {{-- Link --}}
        <div class="relative" x-data="{ open: false }">
            <button type="button"
                @click="saveRange(); open = !open"
                :class="active.createLink ? 'bg-white text-zinc-900 dark:bg-zinc-700 dark:text-zinc-100' : 'text-zinc-500 hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100'"
                class="flex h-7 w-7 items-center justify-center rounded transition"
                title="Insert link" aria-label="Insert link">
                <flux:icon name="link" class="h-4 w-4" />
            </button>

            <div
                x-show="open"
                @click.outside="open = false"
                x-cloak
                class="absolute left-0 top-full z-20 mt-1.5 w-60 rounded-xl border border-zinc-200 bg-white p-2.5 dark:border-zinc-700 dark:bg-zinc-800"
            >
                <input
                    type="text"
                    x-ref="linkInput"
                    x-model="linkUrl"
                    @keydown.enter="applyLink(); open = false"
                    @keydown.escape="open = false"
                    placeholder="https://..."
                    class="w-full rounded-lg border border-zinc-200 bg-white px-2.5 py-1.5 text-xs text-zinc-800 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-200"
                />
                <div class="mt-1.5 flex gap-1.5">
                    <button type="button" @click="open = false"
                        class="flex-1 rounded-lg border border-zinc-200 py-1 text-xs text-zinc-500 hover:bg-zinc-50 dark:border-zinc-600 dark:hover:bg-zinc-700">
                        Batal
                    </button>
                    <button type="button" @click="applyLink(); open = false"
                        class="flex-1 rounded-lg bg-indigo-600 py-1 text-xs font-medium text-white hover:bg-indigo-700">
                        Sisipkan
                    </button>
                </div>
            </div>
        </div>

        <div class="mx-1.5 h-5 w-px bg-zinc-200 dark:bg-zinc-600"></div>

        {{-- Alignment --}}
        <button type="button" @click="fmt('justifyLeft')"
            class="flex h-7 w-7 items-center justify-center rounded text-zinc-500 transition hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100"
            title="Align left" aria-label="Align left">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="15" y2="12"/><line x1="3" y1="18" x2="18" y2="18"/></svg>
        </button>
        <button type="button" @click="fmt('justifyCenter')"
            class="flex h-7 w-7 items-center justify-center rounded text-zinc-500 transition hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100"
            title="Align center" aria-label="Align center">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="6" y1="12" x2="18" y2="12"/><line x1="4" y1="18" x2="20" y2="18"/></svg>
        </button>
        <button type="button" @click="fmt('justifyRight')"
            class="flex h-7 w-7 items-center justify-center rounded text-zinc-500 transition hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100"
            title="Align right" aria-label="Align right">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><line x1="3" y1="6" x2="21" y2="6"/><line x1="9" y1="12" x2="21" y2="12"/><line x1="6" y1="18" x2="21" y2="18"/></svg>
        </button>

        <div class="mx-1.5 h-5 w-px bg-zinc-200 dark:bg-zinc-600"></div>

        {{-- Undo / Redo --}}
        <button type="button" @click="fmt('undo')"
            class="flex h-7 w-7 items-center justify-center rounded text-zinc-500 transition hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100"
            title="Undo" aria-label="Undo">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 14 4 9 9 4"/><path d="M20 20v-7a4 4 0 0 0-4-4H4"/></svg>
        </button>
        <button type="button" @click="fmt('redo')"
            class="flex h-7 w-7 items-center justify-center rounded text-zinc-500 transition hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100"
            title="Redo" aria-label="Redo">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 14 20 9 15 4"/><path d="M4 20v-7a4 4 0 0 1 4-4h12"/></svg>
        </button>

        <div class="mx-1.5 h-5 w-px bg-zinc-200 dark:bg-zinc-600"></div>

        {{-- Clear formatting --}}
        <button type="button" @click="clearFormat()"
            class="flex h-7 w-7 items-center justify-center rounded text-zinc-500 transition hover:bg-white hover:text-zinc-800 dark:hover:bg-zinc-700 dark:hover:text-zinc-100"
            title="Clear formatting" aria-label="Clear formatting">
            <flux:icon name="x-mark" class="h-4 w-4" />
        </button>

    </div>{{-- end toolbar --}}


    {{-- ── Editor area ─────────────────────────────────────────── --}}
    <div
        x-ref="editor"
        contenteditable="true"
        @keyup="updateState(); onInput();"
        @mouseup="updateState(); onInput();"
        data-placeholder="{{ $placeholder }}"
        class="rte-body min-h-[400px] w-full px-6 py-5 text-sm leading-relaxed text-zinc-800 outline-none dark:text-zinc-200
               [&_blockquote]:my-2 [&_blockquote]:border-l-2 [&_blockquote]:border-zinc-300 [&_blockquote]:pl-4 [&_blockquote]:text-zinc-500 [&_blockquote]:dark:border-zinc-600
               [&_code]:rounded [&_code]:bg-zinc-100 [&_code]:px-1.5 [&_code]:py-0.5 [&_code]:font-mono [&_code]:text-xs [&_code]:dark:bg-zinc-800
               [&_pre]:my-2 [&_pre]:rounded-xl [&_pre]:bg-zinc-100 [&_pre]:p-4 [&_pre]:font-mono [&_pre]:text-xs [&_pre]:dark:bg-zinc-800
               [&_h1]:text-2xl [&_h1]:font-semibold [&_h2]:text-xl [&_h2]:font-semibold [&_h3]:text-base [&_h3]:font-semibold
               [&_a]:text-indigo-600 [&_a]:underline [&_a]:dark:text-indigo-400
               [&_ul]:list-disc [&_ul]:pl-5 [&_ol]:list-decimal [&_ol]:pl-5"
    ></div>

    {{-- Hidden input — nilai ini yang dikirim ke controller --}}
    <input type="hidden" :name="fieldName" x-bind:value="content" />


    {{-- ── Footer : word count ─────────────────────────────────── --}}
    <div class="flex items-center justify-between border-t border-zinc-100 bg-zinc-50 px-4 py-2 dark:border-zinc-700 dark:bg-zinc-800">
        <span class="text-[11px] text-zinc-400" x-text="wordCount + ' kata'"></span>
        <span class="text-[11px] text-zinc-400" x-text="charCount + ' karakter'"></span>
    </div>

</div>