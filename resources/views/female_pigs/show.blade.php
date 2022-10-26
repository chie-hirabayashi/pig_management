<x-app-layout>
    <x-slot name="header">
        <h2 class="">
            {{ __('female_pigs.show') }}
        </h2>
    </x-slot>

    <div class="container lg:w-3/4 md:w-4/5 w-11/12 mx-auto my-8 px-8 py-4 bg-stone-200 rounded shadow-md">

        <x-flash-msg :message="session('notice')" />
        <x-error-validation :errors="$errors" />

        <article class="mb-2">
            <h2 class="font-bold font-sans break-normal text-gray-900 pt-6 pb-1 text-3xl md:text-4xl">
                {{ $femalePig->individual_num }}</h2>
            <h2>フラグ表示&切替</h2>
            <h3 class="text-red-600">{{ $femalePig->age }}歳</h3>
            <p class="text-sm mb-2 md:text-base font-normal text-gray-600">
                <span
                    class="text-red-400 font-bold">{{ date('Y-m-d H:i:s', strtotime('-1 day')) < $femalePig->created_at ? 'NEW' : '' }}</span>
            </p>
            <p>平均産子数:1.8</p>
            <p>再発、流産:1回、0.1回/年</p>
            <p>相性の良い組み合わせ:101-1</p>
            <p>出産情報</p>
            <table>
                <tr>
                    <th>出産日</th>
                    <th>出産頭数</th>
                    <th>交配記録</th>
                    <th>回転数</th>
                    <th>備考</th>
                </tr>
                <tr>
                    <td>1999-9-9</td>
                    <td>10</td>
                    <td>101-1,102-1</td>
                    <td>2.0</td>
                    <td></td>
                </tr>
                <tr>
                    <td>1999-9-9</td>
                    <td>11</td>
                    <td>101-1,102-1</td>
                    <td>2.1</td>
                    <td></td>
                </tr>
            </table>

            <p class="text-blue-600">グラフ</p>

            <p>交配記録</p>
            <table>
                <tr>
                    <th>交配日</th>
                    <th>オス1</th>
                    <th>オス2</th>
                    <th>再発予定日1</th>
                    <th>再発予定日2</th>
                    <th>再発日</th>
                    <th>備考</th>
                </tr>
                @foreach ($mixInfos as $mixInfo)
                <tr>
                    <td>{{ $mixInfo->mix_day }}</td>
                    <td>{{ $mixInfo->male_first_id }}</td>
                    <td>{{ $mixInfo->male_second_id }}</td>
                    <td>{{ $mixInfo->recurrence_first_schedule }}</td>
                    <td>{{ $mixInfo->recurrence_second_schedule }}</td>
                    <td>{{ $mixInfo->recurrence_day }}</td>
                    <td>{{ $mixInfo->recurrence_flag, $mixInfo->abortion_flag }}</td>
                </tr>
                @endforeach
            </table>
            <p class="text-pink-600">グラフ</p>
        </article>

        <div class="flex flex-row text-center my-4">
            {{-- @can('update', $post) --}}
            <a href="{{ route('female_pigs.edit', $femalePig) }}"
                class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">編 集</a>
            {{-- @endcan --}}
            {{-- @can('delete', $post) --}}
            <form action="{{ route('female_pigs.destroy', $femalePig) }}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" value="廃 用" onclick="if(!confirm('廃用にしますか？')){return false};"
                    class="bg-pink-400 hover:bg-pink-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-20 mr-2">
            </form>
            <a href="{{ route('female_pigs.mix_infos.create', $femalePig) }}"
                class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-50 mr-2">交配記録の登録</a>
            {{-- @endcan --}}
        </div>
    </div>
</x-app-layout>
