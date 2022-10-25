<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('female_pigs.show') }}
        </h2>
    </x-slot>

    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-stone-200 rounded shadow-md">
        
        <x-flash-msg :message="session('notice')" />
        <x-error-validation :errors="$errors" />

        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">{{ $femalePig->individual_num }}</h2>
            <h2>フラグ表示&切替</h2>
            <h3 class="text-red-600">{{ $femalePig->age }}歳</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $femalePig->created_at ? 'NEW' : '' }}</span>
            </p>
            <p>平均産子数:1.8</p>
            <p>再発、流産:1回、0.1回/年</p>
            <p>相性の良い組み合わせ:101-1</p>
            <p>出産情報</p>
            <table>
                <tr>
                    <th>日付</th>
                    <th>出産頭数</th>
                    <th>交配記録</th>
                    <th>回転数</th>
                    <th>備考</th>
                </tr>
                <tr>
                    <td>1999-9-9</td>
                    <td>10</td>
                    <td>101-1, 102-2</td>
                    <td>2.0</td>
                    <td></td>
                </tr>
                <tr>
                    <td>1999-9-9</td>
                    <td></td>
                    <td>101-1, 102-2</td>
                    <td></td>
                    <td>再発</td>
                </tr>
            </table>

            <p class="text-blue-600">グラフ</p>
            <p class="text-pink-600">グラフ</p>
        </article>

        <div class="flex flex-row text-center my-4">
            {{-- @can('update', $post) --}}
                <a href="{{ route('female_pigs.edit', $femalePig) }}" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編集</a>
            {{-- @endcan --}}
            {{-- @can('delete', $post) --}}
                <form action="{{ route('female_pigs.destroy', $femalePig) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="廃用" onclick="if(!confirm('廃用にしますか？')){return false};" class="bg-pink-400 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20">
                </form>
            {{-- @endcan --}}
        </div>
    </div>
</x-app-layout>
