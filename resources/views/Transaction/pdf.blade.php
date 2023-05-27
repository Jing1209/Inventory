<table >
    <tr>
        <td>Class of Asset</td>
        <td>Asset Identify No</td>
        <td>Description/Specification (Include Serial/Model No,Country of Origin)</td>
        <td>Purchase Date</td>
        <td>Voucher Ref.</td>
        <td>Quantity</td>
        <td>Unit Price</td>
        <td>Amount</td>
        <td>User</td>
        <td>Location and Condition</td>
        <td>Remark</td>
    </tr>
    @foreach ($transactions as $transaction)
        <tr>
            <td>1</td>
            <td>as</td>
            <td>{{$transaction->title}}
                <p>{{$transaction->item_id}}</p>
            </td>
            <td>{{$transaction->created_at}}</td>
            <td>qweqwe</td>
            <td>qweqwe</td>
            <td>{{$transaction->price}}</td>
            <td>{{$transaction->price}}</td>
            <td>{{$transaction->firstname}} {{$transaction->lastname}} <p>{{$transaction->building}}-{{$transaction->name}}</p></td>
            <td>{{$transaction->status}}</td>
            <td>qweqwe</td>
         </tr>
    @endforeach
   
    
        
    
</table>
{{-- {{$newdate}} --}}
<style>
    table,td{
        border:1px solid black;
        border-collapse: collapse;
        
    }
</style>