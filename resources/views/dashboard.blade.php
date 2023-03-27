<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- <h2 class="font-bold">{{__("Current Access Tokens")}}</h2>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Token</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (auth()->user()->tokens as $tok )
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{$tok->name}}</td>
                                    <td class="px-6 py-4">{{$tok->token}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> -->
                    
                    <h2 class="font-bold">{{__("Generate API token")}}</h2>
                    <form>
                    @csrf
                        <input type="text" class="title bg-gray-100 border border-gray-300 p-2 outline-none" name="token_name" placeholder="Enter a token name">
                        <input type="button" name="generate-token" class="btn border border-indigo-500 p-1 px-4 font-semibold cursor-pointer text-gray-200 mt-4 ml-1 bg-indigo-500" value="Generate Token" >
                    </form>

                    <div id="token-response"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(function(){
        $('[name="generate-token"]').click(function(e){
            e.preventDefault();
            let tokeName = $('[name="token_name"]').val();
            console.log(tokeName);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('form input[name="_token"]').val()
                }
            });

            $.ajax(
                {
                    url: "/tokens/create", 
                    method: "post",
                    data: {'token_name' : tokeName},
                    success: function(result){
                        if ( result ) {
                            console.log(result);
                            let responseMarkup = '<p>Here is your API Token: <span class="token font-bold">'+result.token+'</span></p>';
                            $('#token-response').html(responseMarkup);
                            //location.reload();
                        }
                        else {
                            alert('Item is already in the cart');
                        }
                    }   
                });
            });
    });
</script>