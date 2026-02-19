import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

class ModifierPageScreen extends StatefulWidget {
  final Map page; // Data dyal l-page (num_page, contenu, image, audio)
  final Map livre; // Bach n-3rfo l-ktab li m3ah

  const ModifierPageScreen({super.key, required this.page, required this.livre});

  @override
  State<ModifierPageScreen> createState() => _ModifierPageScreenState();
}

class _ModifierPageScreenState extends State<ModifierPageScreen> {
  final _formKey = GlobalKey<FormState>();
  
  late TextEditingController _numPageController;
  late TextEditingController _contenuController;
  File? _newImageFile;
  File? _newAudioFile; // Ila bghiti t-zid hta l-audio picker
  bool _isLoading = false;

  @override
  void initState() {
    super.initState();
    // Chari l-data l-9dima
    _numPageController = TextEditingController(text: widget.page['num_page'].toString());
    _contenuController = TextEditingController(text: widget.page['contenu']);
  }

  Future<void> _pickImage() async {
    final picker = ImagePicker();
    final picked = await picker.pickImage(source: ImageSource.gallery);
    if (picked != null) setState(() => _newImageFile = File(picked.path));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF9FAFB), // gray-50
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0.5,
        iconTheme: const IconThemeData(color: Colors.black87),
        title: RichText(
          text: TextSpan(
            text: "Modifier la Page : ",
            style: const TextStyle(color: Colors.black87, fontSize: 18),
            children: [
              TextSpan(
                text: "${widget.page['num_page']}",
                style: const TextStyle(color: Color(0xFFD97706), fontWeight: FontWeight.bold),
              ),
            ],
          ),
        ),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 24),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              Container(
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                  // Border Amber li khaliha t-chbeh l ModifierLivre
                  border: const Border(top: BorderSide(color: Color(0xFFF59E0B), width: 4)),
                  boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10)],
                ),
                padding: const EdgeInsets.all(20),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // --- NUMERO DE PAGE ---
                    _label("Numéro de la Page"),
                    _textField(_numPageController, "Ex: 1", keyboardType: TextInputType.number),
                    const SizedBox(height: 20),

                    // --- CONTENU ---
                    _label("Contenu de la Page (Texte)"),
                    _textField(_contenuController, "Écrivez le texte de la page ici...", maxLines: 5),
                    const SizedBox(height: 20),

                    // --- IMAGE PICKER ---
                    _label("Image de la page"),
                    Container(
                      padding: const EdgeInsets.all(12),
                      decoration: BoxDecoration(
                        color: const Color(0xFFFFFBEB), // amber-50
                        borderRadius: BorderRadius.circular(8),
                        border: Border.all(color: const Color(0xFFFEF3C7)), // amber-100
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_newImageFile == null && widget.page['image'] != null)
                            Padding(
                              padding: const EdgeInsets.only(bottom: 12),
                              child: Row(
                                children: [
                                  ClipRRect(
                                    borderRadius: BorderRadius.circular(4),
                                    child: Image.network(
                                      "http://10.0.2.2:8000/storage/${widget.page['image']}",
                                      width: 64, height: 64, fit: BoxFit.cover,
                                    ),
                                  ),
                                  const SizedBox(width: 12),
                                  const Text("Image actuelle", 
                                    style: TextStyle(color: Color(0xFFB45309), fontSize: 12, fontStyle: FontStyle.italic)),
                                ],
                              ),
                            ),
                          
                          ElevatedButton.icon(
                            onPressed: _pickImage,
                            icon: const Icon(Icons.image_search, size: 18),
                            label: Text(_newImageFile == null ? "Modifier l'image" : "Nouvelle image choisie ✅"),
                            style: ElevatedButton.styleFrom(
                              backgroundColor: const Color(0xFFFDE68A), // amber-200
                              foregroundColor: const Color(0xFF92400E), // amber-800
                              elevation: 0,
                            ),
                          ),
                        ],
                      ),
                    ),
                    
                    const SizedBox(height: 20),
                    
                    // --- AUDIO (Optionnel) ---
                    _label("Fichier Audio (MP3)"),
                    ListTile(
                      contentPadding: EdgeInsets.zero,
                      leading: Icon(Icons.audiotrack, color: widget.page['audio'] != null ? Colors.green : Colors.grey),
                      title: Text(
                        widget.page['audio'] != null ? "Audio existant" : "Aucun audio",
                        style: const TextStyle(fontSize: 14),
                      ),
                      trailing: TextButton(
                        onPressed: () {}, // Logic pour changer l'audio
                        child: const Text("Changer"),
                      ),
                    ),
                  ],
                ),
              ),
              const SizedBox(height: 30),

              // --- ACTIONS ---
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  TextButton(
                    onPressed: () => Navigator.pop(context),
                    child: const Text("← Annuler", style: TextStyle(color: Colors.grey, fontWeight: FontWeight.bold)),
                  ),
                  ElevatedButton.icon(
                    onPressed: _isLoading ? null : () => _updatePage(),
                    icon: const Icon(Icons.check_circle_outline, size: 18),
                    label: const Text("ENREGISTRER LES MODIFICATIONS"),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.white,
                      foregroundColor: const Color(0xFF4B5563), // gray-600
                      side: const BorderSide(color: Color(0xFFD1D5DB), width: 2),
                      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  // --- UI HELPERS ---
  Widget _label(String text) => Padding(
    padding: const EdgeInsets.only(bottom: 6),
    child: Text(text.toUpperCase(), style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 11, color: Colors.black54)),
  );

  InputDecoration _inputStyle(String hint) => InputDecoration(
    hintText: hint,
    filled: true,
    fillColor: Colors.white,
    contentPadding: const EdgeInsets.all(12),
    border: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: const BorderSide(color: Colors.black12)),
    focusedBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: const BorderSide(color: Color(0xFFF59E0B), width: 2)),
  );

  Widget _textField(TextEditingController ctrl, String hint, {int maxLines = 1, TextInputType keyboardType = TextInputType.text}) {
    return TextFormField(
      controller: ctrl, 
      maxLines: maxLines, 
      keyboardType: keyboardType,
      decoration: _inputStyle(hint),
    );
  }

  void _updatePage() {
    setState(() => _isLoading = true);
    // Hna t-dir l-appel l-API dyal Laravel (PATCH/POST b _method=PUT)
    print("Mise à jour de la page ${widget.page['id']}...");
    
    // Après succès :
    // Navigator.pop(context);
  }
}