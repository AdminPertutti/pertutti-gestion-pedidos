<div class="content-wrapper">
    <section class="content-header">
        <h1>Generador de Menú <small>A4 - 4 por página</small></h1>
    </section>

    <section class="content">
        <div id="react-root"></div>
    </section>
</div>

<!-- Scripts for React/Babel/Tailwind -->
<script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;700&display=swap" rel="stylesheet">

<style>
    @media print {
        /* Force white background on body and all parents */
        html, body, .wrapper, .content-wrapper, .content, #react-root {
            background: white !important;
            background-color: white !important;
            color: black !important;
            margin: 0 !important;
            padding: 0 !important;
            width: auto !important;
            height: auto !important;
            overflow: visible !important;
        }

        /* Hide all UI elements */
        .main-header, .main-sidebar, .main-footer, .control-sidebar, .content-header, .no-print, .btn, .sidebar-toggle { 
            display: none !important; 
        }

        /* Reset content wrapper to fill the page */
        .content-wrapper {
            margin-left: 0 !important;
            min-height: 0 !important;
        }

        @page { 
            size: A4 portrait; 
            margin: 0; 
        }

        /* Ensure the print area is exactly A4 and centered/positioned correctly */
        .print-area { 
            width: 210mm !important; 
            height: 297mm !important; 
            margin: 0 !important; 
            padding: 0 !important;
            box-shadow: none !important;
            transform: none !important;
            border: none !important;
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            background: white !important;
            display: flex !important;
        }
    }
    
    .preview-wrapper {
        overflow-x: auto;
        display: flex;
        justify-content: center;
    }
    .a4-preview {
        width: 210mm;
        height: 297mm;
        min-width: 210mm;
        min-height: 297mm;
        background: white;
    }

    /* Override AdminLTE conflicts with Tailwind if any */
    #react-root {
        font-family: 'Montserrat', sans-serif;
    }
    .gotham-bold {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
    }
    .gotham-light {
        font-family: 'Montserrat', sans-serif;
        font-weight: 300;
    }
</style>

<script type="text/babel">
    const { useState, useEffect } = React;

    const Icons = {
        Printer: () => <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>,
        Edit3: () => <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>,
        Type: () => <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><polyline points="4 7 4 4 20 4 20 7"></polyline><line x1="9" y1="20" x2="15" y2="20"></line><line x1="12" y1="4" x2="12" y2="20"></line></svg>,
        AlignLeft: () => <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><line x1="17" y1="10" x2="3" y2="10"></line><line x1="21" y1="6" x2="3" y2="6"></line><line x1="21" y1="14" x2="3" y2="14"></line><line x1="17" y1="18" x2="3" y2="18"></line></svg>,
        Trash2: () => <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>,
        DollarSign: () => <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>,
        Plus: () => <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>,
        Save: () => <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>,
        History: () => <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline><path d="M3.3 7a10 10 0 1 0 4.5-4.7L3.3 7z"></path><polyline points="3 2 3 7 8 7"></polyline></svg>,
        FilePlus: () => <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
    };

    function App() {
        const [currentId, setCurrentId] = useState(null);
        const [title, setTitle] = useState("SUGERENCIAS\nDEL CHEF");
        const [footer, setFooter] = useState("Menú válido únicamente de lunes a viernes\nal mediodía");
        const [items, setItems] = useState([
            { id: 1, name: "SPAGHETTIS PARISSIENE", price: "$14.000.-", desc: "De espinaca con crema, jamón,\npollo, champignones, gratinados" },
            { id: 2, name: "CAESAR CRISPY", price: "$16.000.-", desc: "Ensalada de lechuga, aderezo caesar,\npollo cripy, croutones y queso parmesano" },
            { id: 3, name: "MILANESA FUGAZZETA", price: "$17.000.-", desc: "De ternera con queso gratinado, cebolla\ndorada y papas fritas" }
        ]);
        
        // Settings for scaling and positioning
        const [config, setConfig] = useState({
            titleSize: 24,
            footerSize: 11,
            itemNameSize: 14,
            itemDescSize: 12,
            itemSpacing: 24,
            cardPadding: 48,
            titleBottomMargin: 24,
            contentWidth: 260
        });

        const [savedMenus, setSavedMenus] = useState([]);
        const [showHistory, setShowHistory] = useState(false);
        const [isSaving, setIsSaving] = useState(false);

        useEffect(() => {
            fetchHistory();
        }, []);

        const fetchHistory = async () => {
            try {
                const response = await fetch('<?php echo base_url("menu/list_available"); ?>');
                const data = await response.json();
                setSavedMenus(data);
                
                // If we are on "New Menu", load config from the most recent one as default
                if (!currentId && data.length > 0) {
                    const lastMenuResponse = await fetch('<?php echo base_url("menu/get_detail/"); ?>' + data[0].id);
                    const lastMenu = await lastMenuResponse.json();
                    if (lastMenu.config) {
                        setConfig(JSON.parse(lastMenu.config));
                    }
                }
            } catch (error) {
                console.error("Error fetching history:", error);
            }
        };

        const handleItemChange = (id, field, value) => {
            setItems(items.map(item => item.id === id ? { ...item, [field]: value } : item));
        };

        const addItem = () => {
            if (items.length < 5) {
                setItems([...items, { id: Date.now(), name: "NUEVO PLATO", price: "$0.000.-", desc: "Descripción del plato" }]);
            }
        };

        const removeItem = (id) => {
            setItems(items.filter(item => item.id !== id));
        };

        const handlePrint = () => window.print();

        const handleSave = async (asNew = false) => {
            setIsSaving(true);
            const formData = new FormData();
            if (!asNew && currentId) formData.append('id', currentId);
            formData.append('titulo', title);
            formData.append('pie', footer);
            formData.append('items', JSON.stringify(items));
            formData.append('config', JSON.stringify(config));

            try {
                const response = await fetch('<?php echo base_url("menu/save"); ?>', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    if (!asNew) setCurrentId(result.id);
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado',
                        text: 'El menú se guardó correctamente',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    fetchHistory();
                } else {
                    Swal.fire('Error', result.message, 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'No se pudo comunicar con el servidor', 'error');
            } finally {
                setIsSaving(false);
            }
        };

        const loadMenu = async (id) => {
            try {
                const response = await fetch('<?php echo base_url("menu/get_detail/"); ?>' + id);
                const data = await response.json();
                setCurrentId(data.id);
                setTitle(data.titulo);
                setFooter(data.pie);
                setItems(JSON.parse(data.items));
                if (data.config) {
                    setConfig(JSON.parse(data.config));
                }
                setShowHistory(false);
            } catch (error) {
                Swal.fire('Error', 'No se pudo cargar el menú', 'error');
            }
        };

        const deleteMenu = async (id) => {
            const confirm = await Swal.fire({
                title: '¿Eliminar menú?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });

            if (confirm.isConfirmed) {
                try {
                    const response = await fetch('<?php echo base_url("menu/delete/"); ?>' + id);
                    const result = await response.json();
                    if (result.success) {
                        fetchHistory();
                        if (currentId == id) handleNew();
                    }
                } catch (error) {
                    Swal.fire('Error', 'No se pudo eliminar', 'error');
                }
            }
        };

        const handleNew = () => {
            setCurrentId(null);
            setTitle("SUGERENCIAS\nDEL CHEF");
            setFooter("Menú válido únicamente de lunes a viernes\nal mediodía");
            setItems([
                { id: 1, name: "SPAGHETTIS PARISSIENE", price: "$14.000.-", desc: "De espinaca con crema, jamón,\npollo, champignones, gratinados" }
            ]);
        };

        const MenuCard = () => (
            <div className="flex flex-col h-full w-full text-center bg-white items-center justify-center" style={{ padding: `${config.cardPadding}px` }}>
                <div style={{ marginBottom: `${config.titleBottomMargin}px` }}>
                    <h1 className="gotham-bold tracking-widest text-gray-900 whitespace-pre-line leading-tight" style={{ fontSize: `${config.titleSize}px` }}>{title}</h1>
                </div>
                <div className="flex-grow flex flex-col justify-center w-full" style={{ gap: `${config.itemSpacing}px`, maxWidth: `${config.contentWidth}px` }}>
                    {items.map((item) => (
                        <div key={`menu-card-${item.id}`} className="flex flex-col items-center">
                            <h2 className="gotham-bold tracking-wider text-gray-900 mb-1" style={{ fontSize: `${config.itemNameSize}px` }}>
                                {item.name} <span className="ml-1">{item.price}</span>
                            </h2>
                            <p className="gotham-light text-gray-600 whitespace-pre-line leading-relaxed" style={{ fontSize: `${config.itemDescSize}px` }}>{item.desc}</p>
                        </div>
                    ))}
                </div>
                <div className="mt-6">
                    <p className="gotham-light text-gray-500 whitespace-pre-line italic max-w-[220px]" style={{ fontSize: `${config.footerSize}px` }}>{footer}</p>
                </div>
            </div>
        );

        const ConfigSlider = ({ label, value, min, max, onChange, unit = "px" }) => (
            <div className="space-y-1">
                <div className="flex justify-between">
                    <label className="text-xs font-medium text-gray-500 uppercase">{label}</label>
                    <span className="text-xs text-emerald-600 font-bold">{value}{unit}</span>
                </div>
                <input type="range" min={min} max={max} value={value} onChange={(e) => onChange(parseInt(e.target.value))} className="w-full h-1.5 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-emerald-500" />
            </div>
        );

        return (
            <div className="flex flex-col md:flex-row font-sans bg-gray-100 min-h-[800px]">
                {/* Editor Sidebar */}
                <div className="w-full md:w-[450px] bg-white shadow-xl flex flex-col h-auto md:h-screen overflow-y-auto no-print border-r border-gray-200 z-10">
                    <div className="p-6 bg-slate-800 text-white flex justify-between items-center sticky top-0 z-20 shadow-md">
                        <div>
                            <h2 className="text-xl font-bold flex items-center gap-2"><Icons.Edit3 /> Editor de Menú</h2>
                            <p className="text-xs text-slate-300 mt-1">{currentId ? `Editando ID: ${currentId}` : 'Nuevo Menú'}</p>
                        </div>
                        <div className="flex gap-2">
                            <button onClick={() => setShowHistory(!showHistory)} className="bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-full transition-all shadow-lg flex items-center justify-center" title="Historial">
                                <Icons.History />
                            </button>
                            <button onClick={handlePrint} className="bg-emerald-500 hover:bg-emerald-600 text-white p-3 rounded-full transition-all shadow-lg flex items-center justify-center transform hover:scale-105" title="Imprimir Menú">
                                <Icons.Printer />
                            </button>
                        </div>
                    </div>

                    <div className="p-6 space-y-6 flex-grow">
                        <div className="flex gap-2">
                             <button onClick={handleNew} className="flex-1 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold flex items-center justify-center gap-2 border border-gray-300">
                                <Icons.FilePlus /> Nuevo
                            </button>
                            <button onClick={() => handleSave(false)} disabled={isSaving} className="flex-1 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold flex items-center justify-center gap-2">
                                <Icons.Save /> {isSaving ? 'Guardando...' : 'Guardar'}
                            </button>
                        </div>

                        {showHistory && (
                            <section className="space-y-2 bg-slate-50 p-4 rounded-xl border border-slate-200">
                                <div className="flex justify-between items-center">
                                    <h3 className="text-xs font-bold text-slate-500 uppercase">Menús Guardados</h3>
                                    <button onClick={() => setShowHistory(false)} className="text-slate-400 hover:text-red-500">×</button>
                                </div>
                                <div className="max-h-60 overflow-y-auto space-y-1">
                                    {savedMenus.map(m => (
                                        <div key={m.id} className="flex items-center justify-between p-2 hover:bg-white rounded border border-transparent hover:border-slate-200 transition-all text-sm group">
                                            <span onClick={() => loadMenu(m.id)} className="cursor-pointer font-medium text-slate-700 flex-grow">
                                                {m.titulo.split('\n')[0]} <span className="text-[10px] text-slate-400 ml-2">{new Date(m.fecha_modificacion).toLocaleDateString()}</span>
                                            </span>
                                            <div className="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button onClick={() => deleteMenu(m.id)} className="text-slate-300 hover:text-red-500">
                                                    <Icons.Trash2 />
                                                </button>
                                            </div>
                                        </div>
                                    ))}
                                    {savedMenus.length === 0 && <p className="text-xs text-slate-400 text-center py-4">No hay menús guardados</p>}
                                </div>
                            </section>
                        )}

                        <section className="space-y-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <h3 className="text-xs font-bold text-slate-500 uppercase flex items-center gap-2">Ajustes de Escala y Posición</h3>
                            <div className="grid grid-cols-2 gap-4">
                                <ConfigSlider label="Tamaño Título" value={config.titleSize} min={12} max={48} onChange={(v) => setConfig({...config, titleSize: v})} />
                                <ConfigSlider label="Tamaño Pie" value={config.footerSize} min={8} max={24} onChange={(v) => setConfig({...config, footerSize: v})} />
                                <ConfigSlider label="Nombre Plato" value={config.itemNameSize} min={10} max={32} onChange={(v) => setConfig({...config, itemNameSize: v})} />
                                <ConfigSlider label="Desc. Plato" value={config.itemDescSize} min={8} max={24} onChange={(v) => setConfig({...config, itemDescSize: v})} />
                                <ConfigSlider label="Espaciado Platos" value={config.itemSpacing} min={0} max={60} onChange={(v) => setConfig({...config, itemSpacing: v})} />
                                <ConfigSlider label="Margen Título" value={config.titleBottomMargin} min={0} max={60} onChange={(v) => setConfig({...config, titleBottomMargin: v})} />
                                <ConfigSlider label="Ancho Contenido" value={config.contentWidth} min={180} max={380} onChange={(v) => setConfig({...config, contentWidth: v})} />
                                <div className="col-span-2">
                                    <ConfigSlider label="Márgenes Internos (Padding)" value={config.cardPadding} min={0} max={100} onChange={(v) => setConfig({...config, cardPadding: v})} />
                                </div>
                            </div>
                        </section>

                        <section className="space-y-4">
                            <h3 className="text-sm font-semibold text-gray-400 uppercase tracking-wider border-b pb-2">Configuración General</h3>
                            <div className="space-y-2">
                                <label className="text-sm font-medium text-gray-700 flex items-center gap-2"><Icons.Type /> Título del Menú</label>
                                <textarea value={title} onChange={(e) => setTitle(e.target.value)} className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-center resize-none bg-slate-50" rows="2" />
                            </div>
                            <div className="space-y-2">
                                <label className="text-sm font-medium text-gray-700 flex items-center gap-2"><Icons.AlignLeft /> Texto al Pie</label>
                                <textarea value={footer} onChange={(e) => setFooter(e.target.value)} className="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all text-center resize-none text-sm bg-slate-50" rows="2" />
                            </div>
                        </section>

                        <section className="space-y-4">
                            <div className="flex justify-between items-center border-b pb-2">
                                <h3 className="text-sm font-semibold text-gray-400 uppercase tracking-wider">Platos Sugeridos</h3>
                                <span className="text-xs bg-slate-100 text-slate-600 px-2 py-1 rounded-full">{items.length} / 5</span>
                            </div>
                            <div className="space-y-4">
                                {items.map((item, index) => (
                                    <div key={item.id} className="p-4 bg-white border border-gray-200 rounded-xl shadow-sm relative group hover:shadow-md transition-shadow">
                                        <div className="absolute -top-3 -left-3 bg-slate-800 text-white w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold shadow-sm">{index + 1}</div>
                                        <button onClick={() => removeItem(item.id)} className="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition-colors bg-white rounded-full p-1" title="Eliminar plato"><Icons.Trash2 /></button>
                                        <div className="space-y-3 mt-1">
                                            <div className="flex gap-2">
                                                <div className="flex-grow space-y-1">
                                                    <label className="text-xs text-gray-500 uppercase font-semibold">Nombre</label>
                                                    <input type="text" value={item.name} onChange={(e) => handleItemChange(item.id, 'name', e.target.value)} className="w-full p-2 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-bold" />
                                                </div>
                                                <div className="w-1/3 space-y-1">
                                                    <label className="text-xs text-gray-500 uppercase font-semibold flex items-center gap-1"><Icons.DollarSign /> Precio</label>
                                                    <input type="text" value={item.price} onChange={(e) => handleItemChange(item.id, 'price', e.target.value)} className="w-full p-2 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-bold text-emerald-700" />
                                                </div>
                                            </div>
                                            <div className="space-y-1">
                                                <label className="text-xs text-gray-500 uppercase font-semibold">Descripción</label>
                                                <textarea value={item.desc} onChange={(e) => handleItemChange(item.id, 'desc', e.target.value)} className="w-full p-2 border border-gray-300 rounded focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 text-sm resize-none" rows="2" />
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            {items.length < 5 && (
                                <button onClick={addItem} className="w-full py-3 border-2 border-dashed border-slate-300 text-slate-600 rounded-xl hover:bg-slate-50 hover:border-slate-400 hover:text-slate-800 transition-all flex items-center justify-center gap-2 font-medium">
                                    <Icons.Plus /> Agregar un plato
                                </button>
                            )}
                        </section>
                    </div>
                </div>

                {/* Preview Area */}
                <div className="flex-1 bg-slate-200 py-8 preview-wrapper">
                    <div className="a4-preview print-area shadow-2xl mx-auto flex bg-white">
                        <div className="w-full h-full grid grid-cols-2 grid-rows-2 gap-0">
                            <MenuCard /><MenuCard /><MenuCard /><MenuCard />
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    const root = ReactDOM.createRoot(document.getElementById('react-root'));
    root.render(<App />);
</script>
