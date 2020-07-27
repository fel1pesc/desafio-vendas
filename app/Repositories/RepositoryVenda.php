<?php


namespace App\Repositories;


use App\Models\Venda;
use Illuminate\Http\Request;

class RepositoryVenda extends RepositoryBase
{
    private $repositoryVendaHasItem;

    public function __construct(Request $request)
    {
        parent::__construct(new Venda(), $request);
        $this->repositoryVendaHasItem = new RepositoryVendaHasItem($request);
    }

    public function store(){
        try {
            \DB::beginTransaction();

            $id = $this->request->input('id');
            $itens = $this->request->input('itens_values');

            $venda = Venda::findOrNew($id);

            $venda->fill($this->request->all());

            $validate = validator($this->request->all(), $venda->rules(), $venda->mensages);

            if ($validate->fails())
                return redirect()->back()->withErrors($validate)->withInput();

            $venda->save();

            $itens = json_decode($itens, true) ?? [];

            foreach ($itens as $row) {

                if($row['deletar'] == true)
                    $this->repositoryVendaHasItem->deletarPorId($row['id']);

                elseif($row['id'] === 0 && $row['deletar'] == false)
                {
                    $item = ['venda_id' => $venda->id,
                        'item_id' => $row['item_id'],
                        'quantidade' => $row['qtd'],
                        'preco' => $row['preco']];

                    $this->repositoryVendaHasItem->criar($item);
                }
            }

            DB::commit();
            return redirect()->route('venda.index')->withStatus('Venda cadastrada com sucesso!');
        } catch (\Exception $exc){
            DB::rollBack();
            return redirect()->back()->with('validation', $exc->getMessage());
        }
    }

    public function destroy()
    {
        try {
            \DB::beginTransaction();

            $id = $this->request->input('id');

            $this->repositoryVendaHasItem->deletarPorVendaId($id);

            $delete = $this->repositoryVenda->deletarPorId($id);

            if(!$delete)
                throw new \Exception('Erro ao excluir Venda');

            \DB::commit();
            return response()->json(['success' => true, 'msg'=> 'Venda excluida com sucesso.']);

        } catch (\Exception $exc){
            \DB::rollback();
            return response()->json(['success' => null, 'msg' => $exc->getMessage()]);
        }
    }
}
