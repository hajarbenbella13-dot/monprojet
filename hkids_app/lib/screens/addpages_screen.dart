import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:file_picker/file_picker.dart'; // ✅ Pour l'audio
import 'package:path/path.dart' as p;

class AddPageScreen extends StatefulWidget {
  final Map livre;
  const AddPageScreen({super.key, required this.livre});

  @override
  State<AddPageScreen> createState() => _AddPageScreenState();
}

class _AddPageScreenState extends State<AddPageScreen> {
  final _formKey = GlobalKey<FormState>();
  
  final TextEditingController _numController = TextEditingController();
  final TextEditingController _contentController = TextEditingController();
  
  File? _imageFile;
  File? _audioFile;
  bool _isLoading = false;

  // Picker dyal Image
  Future<void> _pickImage() async {
    final picker = ImagePicker();
    final picked = await picker.pickImage(source: ImageSource.gallery);
    if (picked != null) setState(() => _imageFile = File(picked.path));
  }

  // Picker dyal Audio
  Future<void> _pickAudio() async {
    FilePickerResult? result = await FilePicker.platform.pickFiles(type: FileType.audio);
    if (result != null) setState(() => _audioFile = File(result.files.single.path!));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF9FAFB),
      appBar: AppBar(
        title: Text("Ajouter une page à : ${widget.livre['titre']}", 
          style: const TextStyle(color: Colors.black87, fontSize: 16)),
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
              // --- FORM CONTAINER ---
              Container(
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                  // Border blue f l-fouq bach iji style mbeddel 3la Ajouter Livre
                  border: const Border(top: BorderSide(color: Color(0xFF3B82F6), width: 4)),
                  boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10)],
                ),
                padding: const EdgeInsets.all(20),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _label("Numéro de la page"),
                    _textField(_numController, "Ex: 1", keyboardType: TextInputType.number),
                    const SizedBox(height: 20),

                    _label("Contenu (Texte)"),
                    _textField(_contentController, "Le texte de la page...", maxLines: 4),
                    const SizedBox(height: 20),

                    _label("Illustration (Image)"),
                    _filePicker(
                      label: _imageFile == null ? "Choisir une image" : "Image sélectionnée ✅",
                      icon: Icons.image,
                      color: const Color(0xFFEFF6FF), // Blue shade
                      onTap: _pickImage,
                    ),
                    const SizedBox(height: 20),

                    _label("Fichier Audio (MP3)"),
                    _filePicker(
                      label: _audioFile == null ? "Choisir un audio" : "Audio : ${p.basename(_audioFile!.path)}",
                      icon: Icons.mic,
                      color: const Color(0xFFF0FDF4), // Green shade
                      onTap: _pickAudio,
                    ),
                  ],
                ),
              ),
              
              const SizedBox(height: 30),

              // --- BUTTONS ---
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  TextButton(
                    onPressed: () => Navigator.pop(context),
                    child: const Text("Annuler", style: TextStyle(color: Colors.grey, fontWeight: FontWeight.bold)),
                  ),
                  ElevatedButton.icon(
                    onPressed: _isLoading ? null : () => _submit(),
                    icon: const Icon(Icons.save, size: 18),
                    label: const Text("ENREGISTRER LA PAGE"),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.white,
                      foregroundColor: Colors.black87,
                      side: const BorderSide(color: Colors.black12, width: 1.5),
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

  // --- UI HELPERS (B7al l-code dyalk) ---
  Widget _label(String text) => Padding(
    padding: const EdgeInsets.only(bottom: 6),
    child: Text(text, style: const TextStyle(fontWeight: FontWeight.bold, color: Colors.black87, fontSize: 13)),
  );

  InputDecoration _inputStyle(String hint) => InputDecoration(
    hintText: hint,
    filled: true,
    fillColor: const Color(0xFFF9FAFB),
    contentPadding: const EdgeInsets.all(12),
    border: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: const BorderSide(color: Color(0xFFE5E7EB))),
    focusedBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: const BorderSide(color: Color(0xFF3B82F6), width: 2)),
  );

  Widget _textField(TextEditingController ctrl, String hint, {int maxLines = 1, TextInputType keyboardType = TextInputType.text}) {
    return TextFormField(
      controller: ctrl,
      maxLines: maxLines,
      keyboardType: keyboardType,
      decoration: _inputStyle(hint),
    );
  }

  Widget _filePicker({required String label, required IconData icon, required Color color, required VoidCallback onTap}) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        width: double.infinity,
        padding: const EdgeInsets.all(14),
        decoration: BoxDecoration(
          color: color,
          borderRadius: BorderRadius.circular(8),
          border: Border.all(color: Colors.black.withOpacity(0.05)),
        ),
        child: Row(
          children: [
            Icon(icon, color: Colors.black54, size: 20),
            const SizedBox(width: 12),
            Expanded(child: Text(label, maxLines: 1, overflow: TextOverflow.ellipsis, style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w600))),
          ],
        ),
      ),
    );
  }

  void _submit() {
    if (_formKey.currentState!.validate()) {
       // Hna ghadi t-dir l-appel l-API dyal Laravel mmen ba3d
       print("Data ready to save!");
    }
  }
}