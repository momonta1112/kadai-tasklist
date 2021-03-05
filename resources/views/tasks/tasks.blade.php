@if (count($tasks) > 0)
    <ul class="list-unstyled">
        @foreach ($tasks as $task)
            <li class="media mb-3">
                <div>
                {{-- 投稿内容 --}}
                    <p class="mb-0">{!! nl2br(e($task->content)) !!}</p>
                </div>
                
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $tasks->links() }}
@endif