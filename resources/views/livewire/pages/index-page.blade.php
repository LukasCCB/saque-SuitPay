<div>
    <flux:main container>

        <flux:heading size="xl" level="1">Sistema de Saque - {{ config('app.name') }}</flux:heading>
        <flux:text class="mt-2 mb-6 text-base">Nenhuma informação é armazenada no sistema, ao atualizar a página ou
            sair. Tudo será perdido!
        </flux:text>
        <flux:separator variant="subtle"/>

        <form method="POST" wire:submit="send" class="flex flex-col gap-6">

            <flux:callout variant="warning" icon="exclamation-circle" heading="Se der erro de acesso, autorize o IP deste servidor (peça ao desenvolvedor)" />

            <div class="flex text-center justify-center items-center">
                <flux:error name="key_pub"/>
                <flux:error name="key_secret"/>
                <flux:error name="pix_key"/>
                <flux:error name="amount"/>
            </div>

            <div class="my-5 grid grid-cols-2 gap-5">

                <flux:field>
                    <flux:label badge="Obrigatório">Chave Púbica</flux:label>
                    <flux:input wire:model="key_pub" type="password" placeholder="sk_......" size="sm" viewable required
                                clearable/>

                </flux:field>

                <flux:field>
                    <flux:label badge="Obrigatório">Chave Secreta</flux:label>
                    <flux:input wire:model="key_secret" type="password" placeholder="sk_......" size="sm" viewable required
                                clearable/>
                </flux:field>

            </div>

            <div class="my-5 grid grid-cols-2 gap-5">

                <flux:input.group label="Chave PIX">
                    <flux:select class="max-w-fit" variant="listbox" placeholder="Tipo de Chave" size="sm" wire:model="pix_key_type" required>

                        <flux:select.option value="randomKey" selected>
                            <div class="flex items-center gap-2">
                                <flux:icon.asterisk variant="mini" class="text-zinc-400"/> Aleatório
                            </div>
                        </flux:select.option>

                        <flux:select.option value="document">
                            <div class="flex items-center gap-2">
                                <flux:icon.id-card variant="mini" class="text-zinc-400"/> CPF
                            </div>
                        </flux:select.option>

                        <flux:select.option value="email">
                            <div class="flex items-center gap-2">
                                <flux:icon.mail variant="mini" class="text-zinc-400"/> E-mail
                            </div>
                        </flux:select.option>

                        <flux:select.option value="phoneNumber">
                            <div class="flex items-center gap-2">
                                <flux:icon.phone variant="mini" class="text-zinc-400"/> Telefone
                            </div>
                        </flux:select.option>

                        <flux:select.option value="paymentCode">
                            <div class="flex items-center gap-2">
                                <flux:icon.qr-code variant="mini" class="text-zinc-400"/> qrCode
                            </div>
                        </flux:select.option>
                    </flux:select>

                    <flux:input wire:model="pix_key" required placeholder="Digite sua chave PIX..." size="sm" clearable/>
                </flux:input.group>

                <flux:field>
                    <flux:label badge="R$">Valor</flux:label>
                    <flux:input wire:model="amount" type="text" placeholder="10.00" size="sm" clearable required/>
                </flux:field>


            </div>

            <flux:button type="submit" variant="primary" class="w-full" icon="paper-airplane">Efetuar Saque</flux:button>

        </form>

        <div class="mt-5">
            <flux:textarea
                wire:model="live_log"
                label="Relatório em Tempo real"
                badge="Logs"
                disabled
                placeholder="Aguardando operação..."
            />
        </div>

    </flux:main>
</div>
