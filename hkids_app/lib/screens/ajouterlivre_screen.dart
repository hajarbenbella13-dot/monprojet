import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:file_picker/file_picker.dart'; 

class AjouterLivreScreen extends StatefulWidget {
  const AjouterLivreScreen({super.key});

  @override
  State<AjouterLivreScreen> createState() => _AjouterLivreScreenState();
}

class _AjouterLivreScreenState extends State<AjouterLivreScreen> {
  final _formKey = GlobalKey<FormState>();
  
  final TextEditingController _titreController = TextEditingController();
  final TextEditingController _descController = TextEditingController();
  
  String? _selectedAgeRange;
  File? _imageFile;
  File? _audioFile;
  bool _isLoading = false;

  Future<void> _pickImage() async {
    final picker = ImagePicker();
    final picked = await picker.pickImage(source: ImageSource.gallery);
    if (picked != null) setState(() => _imageFile = File(picked.path));
  }

  Future<void> _pickAudio() async {
    FilePickerResult? result = await FilePicker.platform.pickFiles(
      type: FileType.audio,
    );
    if (result != null) setState(() => _audioFile = File(result.files.single.path!));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF9FAFB),
      appBar: AppBar(
        title: const Text("Ajouter un nouveau livre", style: TextStyle(color: Colors.black87, fontSize: 18)),
        backgroundColor: Colors.white,
        elevation: 0.5,
        iconTheme: const IconThemeData(color: Colors.black87),
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
                  // Fix: Colors.emerald -> Color(0xFF10B981)
                  border: const Border(top: BorderSide(color: Color(0xFF10B981), width: 4)),
                  boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10)],
                ),
                padding: const EdgeInsets.all(20),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _label("Titre du livre"),
                    _textField(_titreController, "Ex: Le Petit Prince"),
                    const SizedBox(height: 20),

                    _label("Description"),
                    _textField(_descController, "Résumé du livre...", maxLines: 3),
                    const SizedBox(height: 20),

                    _label("Tranche d'âge cible"),
                    DropdownButtonFormField<String>(
                      value: _selectedAgeRange,
                      decoration: _inputStyle(""),
                      hint: const Text("Choisissez une tranche d'âge"),
                      items: const [
                        DropdownMenuItem(value: "2-5", child: Text("👶 De 2 à 5 ans")),
                        DropdownMenuItem(value: "6-10", child: Text("👦 De 6 à 10 ans")),
                      ],
                      onChanged: (v) => setState(() => _selectedAgeRange = v),
                    ),
                    const SizedBox(height: 20),

                    _label("Photo de couverture"),
                    _filePicker(
                      label: _imageFile == null ? "Choisir une photo" : "Photo sélectionnée ✅",
                      icon: Icons.image,
                      // Fix: Colors.emerald.shade50 -> Color(0xFFECFDF5)
                      color: const Color(0xFFECFDF5),
                      onTap: _pickImage,
                    ),
                    const SizedBox(height: 20),

                    _label("Fichier Audio (MP3/WAV)"),
                    _filePicker(
                      label: _audioFile == null ? "Choisir un audio" : "Audio sélectionné ✅",
                      icon: Icons.audiotrack,
                      // Fix: Colors.slate.shade50 -> Color(0xFFF1F5F9)
                      color: const Color(0xFFF1F5F9),
                      onTap: _pickAudio,
                    ),
                  ],
                ),
              ),
              const SizedBox(height: 30),

              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  TextButton(
                    onPressed: () => Navigator.pop(context),
                    child: const Text("Annuler", style: TextStyle(color: Colors.grey, fontWeight: FontWeight.bold)),
                  ),
                  ElevatedButton.icon(
                    onPressed: _isLoading ? null : () => _submit(),
                    icon: const Icon(Icons.add, size: 18),
                    label: const Text("CRÉER LE LIVRE"),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.white,
                      foregroundColor: Colors.black87,
                      side: const BorderSide(color: Colors.grey, width: 2),
                      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 12),
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

  Widget _label(String text) => Padding(
    padding: const EdgeInsets.only(bottom: 6),
    // Fix: Colors.blackDE -> Colors.black87
    child: Text(text, style: const TextStyle(fontWeight: FontWeight.bold, color: Colors.black87)),
  );

  InputDecoration _inputStyle(String hint) => InputDecoration(
    hintText: hint,
    filled: true,
    fillColor: Colors.white,
    contentPadding: const EdgeInsets.all(12),
    border: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: const BorderSide(color: Colors.grey)),
    // Fix: Colors.emerald -> Color(0xFF10B981)
    focusedBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: const BorderSide(color: Color(0xFF10B981), width: 2)),
  );

  Widget _textField(TextEditingController ctrl, String hint, {int maxLines = 1}) {
    return TextFormField(
      controller: ctrl,
      maxLines: maxLines,
      decoration: _inputStyle(hint),
    );
  }

  Widget _filePicker({required String label, required IconData icon, required Color color, required VoidCallback onTap}) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        width: double.infinity,
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: color,
          borderRadius: BorderRadius.circular(8),
          border: Border.all(color: Colors.black12),
        ),
        child: Row(
          children: [
            Icon(icon, color: Colors.black54),
            const SizedBox(width: 12),
            Text(label, style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w600)),
          ],
        ),
      ),
    );
  }

  void _submit() {
    // Logic dyal hna...
  }
}